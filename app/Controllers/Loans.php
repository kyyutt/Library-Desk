<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LoansModel;
use App\Models\BooksModel;
use App\Models\MembersModel;
use App\Models\ReservationModel;
use App\Models\FinesModel;
use App\Models\FineSettingsModel;

class Loans extends BaseController
{
    protected $loanModel;
    protected $booksModel;
    protected $membersModel;
    protected $reservationModel;
    protected $finesModel;
    protected $fineSettingsModel;

    public function __construct()
    {
        $this->loanModel = new LoansModel();
        $this->booksModel = new BooksModel();
        $this->membersModel = new MembersModel();
        $this->reservationModel = new ReservationModel();
        $this->finesModel = new FinesModel();
        $this->fineSettingsModel = new FineSettingsModel();
    }

    public function index()
    {
        $loans = $this->loanModel->findAll();
        $books = $this->booksModel->findAll();
        $members = $this->membersModel->findAll();

        $loans = array_filter($loans, function ($loan) {
            return is_null($loan['return_date']);
        });

        foreach ($loans as &$loan) {
            $member = array_filter($members, fn($m) => $m['id'] === $loan['member_id']);
            $loan['member_name'] = !empty($member) ? reset($member)['name'] : 'No member found';

            $book = array_filter($books, fn($b) => $b['id'] === $loan['book_id']);
            $loan['book_title'] = !empty($book) ? reset($book)['title'] : 'No book found';

            $this->applyFines($loan);
        }

        $data['loans'] = $loans;
        return view('loans/index', $data);
    }

    private function applyFines($loan)
{
    $today = date('Y-m-d');

    $fineSetting = $this->fineSettingsModel->find($loan['fine_setting_id']);

    if (!$fineSetting || !$fineSetting['is_active']) {
        return;
    }

    $finePerDay = $fineSetting['fine_per_day'];

    // Check if the loan is overdue and there's no unpaid fine
    if ($loan['due_date'] < $today) {
        $fine = $this->finesModel->where('loan_id', $loan['id'])->orderBy('id', 'desc')->first();

        if ($fine && $fine['status'] === 'paid') {
            // Skip if the last fine record is paid
            return;
        }

        // Calculate days overdue
        $daysOverdue = (strtotime($today) - strtotime($loan['due_date'])) / (60 * 60 * 24);
        $fineAmount = $daysOverdue * $finePerDay;

        if (!$fine) {
            // Create new fine record if none exists
            $this->finesModel->save([
                'loan_id' => $loan['id'],
                'fine_amount' => $fineAmount,
                'status' => 'unpaid'
            ]);
            $this->loanModel->update($loan['id'], ['status' => 'Overdue']);
        } else {
            // Update existing fine record if unpaid
            $this->finesModel->update($fine['id'], ['fine_amount' => $fineAmount]);
        }
    }
}


    public function create()
    {
        $data['members'] = $this->membersModel->findAll();
        $data['books'] = $this->booksModel->findAvailableBooks(); // Find available books for loan

        return view('loans/create', $data);
    }

    public function store()
    {
        $loanDate = $this->request->getPost('loan_date');
        $dueDate = date('Y-m-d', strtotime($loanDate . ' + 7 days'));

        // Ensure the active fine setting is available
        $fineSetting = $this->fineSettingsModel->where('is_active', 1)->first();

        if (!$fineSetting) {
            return redirect()->back()->with('error', 'No active fine setting found.');
        }

        // Prepare loan data
        $data = [
            'member_id' => $this->request->getPost('member_id'),
            'book_id' => $this->request->getPost('book_id'),
            'loan_date' => $loanDate,
            'due_date' => $dueDate,
            'return_date' => null,
            'fine_setting_id' => $fineSetting['id'],  // Ensure using the active fine setting
            'status' => 'On Loan',
        ];

        // Save loan data
        $this->loanModel->save($data);

        // Update the book status to 'borrowed'
        $this->booksModel->update($this->request->getPost('book_id'), ['status' => 'borrowed']);

        // Handle reservations
        $reservation = $this->reservationModel->where('book_id', $this->request->getPost('book_id'))
            ->where('status', 'active')
            ->first();

        if ($reservation) {
            // Mark the reservation as completed
            $this->reservationModel->update($reservation['id'], ['status' => 'completed']);
        }

        return redirect()->to('/loans')->with('success', 'Loan successfully added.');
    }


    public function returnLoan($id)
    {
        $loan = $this->loanModel->find($id);

        if (!$loan) {
            return redirect()->to('/loans')->with('error', 'Loan not found.');
        }

        // Check if there are unpaid fines before returning the loan
        $fine = $this->finesModel->where('loan_id', $id)->where('status', 'unpaid')->first();
        // dd($fine);
        if ($fine) {
            return redirect()->to('/loans')->with('error', 'Cannot return loan with unpaid fines.');
        }

        // Update loan return information
        $this->loanModel->update($id, [
            'return_date' => date('Y-m-d'),
            'status' => 'Returned'  // Set the status to 'Returned'
        ]);

        // Update the book's status to 'available' after return
        $this->booksModel->update($loan['book_id'], ['status' => 'available']);

        return redirect()->to('/loans')->with('success', 'Loan successfully returned and status updated to Returned.');
    }


    public function extendDueDate($loanId)
    {
        // Find the loan based on the loanId
        $loan = $this->loanModel->find($loanId);

        if (!$loan) {
            return redirect()->to('/loans')->with('error', 'Loan not found.');
        }

        $fine = $this->finesModel->where('loan_id', $loanId)->where('status', 'unpaid')->first();

        if ($fine) {
            return redirect()->to('/loans')->with('error', 'Please pay the fine before extending the due date.');
        }

        // Check if the fine setting is active (fine setting with is_active = 1)
        $fineSetting = $this->fineSettingsModel->where('is_active', 1)->first();

        if (!$fineSetting) {
            // If no active fine setting is found, handle this situation
            return redirect()->to('/loans')->with('error', 'No active fine setting found.');
        }

        // Extend the due date by adding 7 days to the current due date
        $newDueDate = date('Y-m-d', strtotime($loan['due_date'] . ' +7 days'));

        // Update the loan with the new due date and mark it as 'Extended'
        $this->loanModel->update($loanId, [
            'due_date' => $newDueDate,
            'status' => 'Extended'
        ]);

        // Return a success message with the new due date
        return redirect()->to('/loans')->with('success', 'Due date extended to ' . $newDueDate);
    }
}
