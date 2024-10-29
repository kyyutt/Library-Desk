<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LoansModel;
use App\Models\BooksModel;
use App\Models\MembersModel;
use App\Models\ReservationModel;
use App\Models\FinesModel;

class Loans extends BaseController
{
    protected $loanModel;
    protected $booksModel;
    protected $membersModel;
    protected $reservationModel;
    protected $finesModel;
    protected $finePerDay = 1000;

    public function __construct()
    {
        $this->loanModel = new LoansModel();
        $this->booksModel = new BooksModel();
        $this->membersModel = new MembersModel();
        $this->reservationModel = new ReservationModel();
        $this->finesModel = new FinesModel();
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
        if ($loan['due_date'] < $today && !$this->finesModel->where('loan_id', $loan['id'])->first()) {
            $daysOverdue = (strtotime($today) - strtotime($loan['due_date'])) / (60 * 60 * 24);
            $fineAmount = $daysOverdue * $this->finePerDay;

            $this->finesModel->save([
                'loan_id' => $loan['id'],
                'fine_amount' => $fineAmount,
                'status' => 'unpaid'
            ]);
        }
    }

    public function create()
    {
        $data['members'] = $this->membersModel->findAll();
        $data['books'] = $this->booksModel->findAvailableBooks();

        return view('loans/create', $data);
    }


    public function store()
    {
        $loanDate = $this->request->getPost('loan_date');
        $dueDate = date('Y-m-d', strtotime($loanDate . ' + 7 days'));

        $data = [
            'member_id' => $this->request->getPost('member_id'),
            'book_id' => $this->request->getPost('book_id'),
            'loan_date' => $loanDate,
            'due_date' => $dueDate,
            'return_date' => null,
        ];

        $this->loanModel->save($data);
        $this->booksModel->update($this->request->getPost('book_id'), ['status' => 'borrowed']);

        $reservation = $this->reservationModel->where('book_id', $this->request->getPost('book_id'))
            ->where('status', 'active')
            ->first();

        if ($reservation) {
            $this->reservationModel->update($reservation['id'], ['status' => 'completed']);
        }

        return redirect()->to('/admin/loans')->with('success', 'Loan successfully added.');
    }

    public function returnLoan($id)
    {
        $loan = $this->loanModel->find($id);

        if (!$loan) {
            return redirect()->to('/admin/loans')->with('error', 'Loan not found.');
        }

        $fine = $this->finesModel->where('loan_id', $id)->where('status', 'unpaid')->first();
        if ($fine) {
            return redirect()->to('/admin/loans')->with('error', 'Cannot return loan with unpaid fines.');
        }

        $this->loanModel->update($id, [
            'return_date' => date('Y-m-d')
        ]);

        $this->booksModel->update($loan['book_id'], ['status' => 'available']);

        return redirect()->to('/admin/loans')->with('success', 'Loan successfully returned.');
    }


    public function extendDueDate($loanId)
    {
        $loan = $this->loanModel->find($loanId);

        if ($loan) {
            $newDueDate = date('Y-m-d', strtotime($loan['due_date'] . ' +7 days'));
            $this->loanModel->update($loanId, ['due_date' => $newDueDate]);

            $this->finesModel->where('loan_id', $loanId)->delete();

            return redirect()->to('admin/loans')->with('success', 'Due date extended to ' . $newDueDate);
        } else {
            return redirect()->to('admin/loans')->with('error', 'Loan not found.');
        }
    }
}
