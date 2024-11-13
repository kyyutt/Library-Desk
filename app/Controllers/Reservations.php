<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ReservationModel;
use App\Models\BooksModel;
use App\Models\MembersModel;
use App\Models\LoansModel;

class Reservations extends BaseController
{
    protected $reservationModel;
    protected $booksModel;
    protected $membersModel;
    protected $loansModel;

    public function __construct()
    {
        $this->reservationModel = new ReservationModel();
        $this->booksModel = new BooksModel();
        $this->membersModel = new MembersModel();
        $this->loansModel = new LoansModel();
    }

    public function index()
    {
        $reservations = $this->reservationModel->findAll();

        $books = $this->booksModel->findAll();
        $members = $this->membersModel->findAll();

        foreach ($reservations as &$reservation) {
            $member = array_filter($members, function ($m) use ($reservation) {
                return $m['id'] === $reservation['member_id'];
            });
            $reservation['member_name'] = !empty($member) ? reset($member)['name'] : 'No member found';

            $book = array_filter($books, function ($b) use ($reservation) {
                return $b['id'] === $reservation['book_id'];
            });
            $reservation['book_title'] = !empty($book) ? reset($book)['title'] : 'No book found';
        }

        $data['reservations'] = $reservations;
        return view('reservations/index', $data);
    }

    public function create()
    {
        $loansModel = new LoansModel();
        $membersModel = new MembersModel();
        $booksModel = new BooksModel();

        // Get active loans (books that are currently borrowed)
        $activeLoans = $loansModel->where('return_date', null)->findAll();

        // Get all books
        $allBooks = $booksModel->findAll();

        // Get borrowed books' IDs
        $borrowedBookIds = array_column($activeLoans, 'book_id');

        // Filter out borrowed books to get available books
        if (!empty($borrowedBookIds)) {
            $availableBooks = $booksModel->whereNotIn('id', $borrowedBookIds)->findAll();
        } else {
            $availableBooks = $allBooks;  // If no books are borrowed, all books are available
        }

        // Get available members (members who haven't borrowed a book)
        $borrowedMemberIds = array_column($activeLoans, 'member_id');
        if (!empty($borrowedMemberIds)) {
            $availableMembers = $membersModel->whereNotIn('id', $borrowedMemberIds)->findAll();
        } else {
            $availableMembers = $membersModel->findAll();
        }

        // Add book and member information to active loans
        foreach ($activeLoans as &$loan) {
            // Add member name to each loan
            $member = $membersModel->find($loan['member_id']);
            $loan['member_name'] = $member['name'];

            // Add book title to each loan
            $book = $booksModel->find($loan['book_id']);
            $loan['book_title'] = $book['title'];
        }

        return view('reservations/create', [
            'availableBooks' => $availableBooks,  // Available books
            'activeLoans' => $activeLoans,        // Currently borrowed books
            'availableMembers' => $availableMembers, // Available members
            'reservationDate' => date('Y-m-d'),  // Current date for reservation
        ]);
    }



    public function store()
    {
        // Step 1: Save the reservation data
        $data = [
            'member_id' => $this->request->getPost('member_id'),
            'book_id' => $this->request->getPost('book_id'),
            'reservation_date' => $this->request->getPost('reservation_date'),
            'status' => 'active', // Initial reservation status
        ];
        $this->reservationModel->save($data);

        // Step 2: Update the book status to "reserved"
        $this->booksModel->update($this->request->getPost('book_id'), ['status' => 'reserved']);

        // Step 3: Check if the book is currently "borrowed"
        $loan = $this->loansModel
            ->where('book_id', $this->request->getPost('book_id'))
            ->where('status', 'On Loan')  // Checking if the book is currently on loan
            ->first();

        if ($loan) {
            // If the book is borrowed, update the loan status to "Reserved"
            $this->loansModel->update($loan['id'], ['status' => 'Reserved']);
        }

        // Step 4: Redirect back with a success message
        return redirect()->to('/reservations')->with('success', 'Reservation successfully added, and loan status updated to Reserved.');
    }



    public function complete($id)
    {
        // Step 1: Find the reservation record
        $reservation = $this->reservationModel->find($id);

        // Check if the reservation exists and is active
        if ($reservation && $reservation['status'] == 'active') {

            // Step 2: Get the active loan for the given book and member
            $existingLoan = $this->loansModel->where('book_id', $reservation['book_id'])
                ->where('status', 'Returned')
                ->first();

            if (!$existingLoan) {
                return redirect()->to('/reservations')->with('error', 'The book has not been returned yet.');
            }

            $this->reservationModel->update($id, ['status' => 'completed']);

            $fineSettingsModel = new \App\Models\FineSettingsModel();
            $activeFineSetting = $fineSettingsModel->where('is_active', 1)->first();

            if (!$activeFineSetting) {
                return redirect()->to('/reservations')->with('error', 'No active fine setting found.');
            }

            // Step 5: Insert a new loan record
            $this->loansModel->insert([
                'book_id' => $reservation['book_id'],
                'member_id' => $reservation['member_id'],
                'loan_date' => date('Y-m-d'),
                'due_date' => date('Y-m-d', strtotime('+7 days')),
                'fine_setting_id' => $activeFineSetting['id'],  // Set the fine_setting_id
                'status' => 'On Loan'  // Set the status to "On Loan"
            ]);

            // Redirect back with a success message
            return redirect()->to('/reservations')->with('success', 'Reservation marked as completed and loan created.');
        }

        // If the reservation is invalid or inactive
        return redirect()->to('/reservations')->with('error', 'Invalid reservation or action.');
    }



    public function cancel($id)
    {
        $reservation = $this->reservationModel->find($id);

        if ($reservation && $reservation['status'] == 'active') {
            // Step 1: Update reservation status to cancelled
            $this->reservationModel->update($id, ['status' => 'cancelled']);

            // Step 2: Check if there's an active loan associated with the reservation's book
            $loan = $this->loansModel
                ->where('book_id', $reservation['book_id'])
                ->where('status', 'Reserved')  // Checking if the book is reserved
                ->first();

            if ($loan) {
                // Step 3: If the loan is found, change the status to 'On Loan'
                $this->loansModel->update($loan['id'], ['status' => 'On Loan']);
            }

            // Step 4: Redirect back with a success message
            return redirect()->to('/reservations')->with('success', 'Reservation cancelled and loan status updated to "On Loan".');
        }

        // If the reservation is invalid or inactive
        return redirect()->to('/reservations')->with('error', 'Invalid reservation or action.');
    }
}
