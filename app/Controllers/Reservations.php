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

        $activeLoans = $loansModel->where('return_date', null)->findAll();

        $borrowedMemberIds = array_column($activeLoans, 'member_id');

        if (!empty($borrowedMemberIds)) {
            $availableMembers = $membersModel->whereNotIn('id', $borrowedMemberIds)->findAll();
        } else {
            $availableMembers = $membersModel->findAll();
        }

        foreach ($activeLoans as &$loan) {
            $member = $membersModel->find($loan['member_id']);
            $loan['member_name'] = $member['name'];
            $book = $booksModel->find($loan['book_id']);
            $loan['book_title'] = $book['title'];
        }

        return view('reservations/create', [
            'availableMembers' => $availableMembers,
            'activeLoans' => $activeLoans,
            'reservationDate' => date('Y-m-d'),
        ]);
    }

    public function store()
    {
        $data = [
            'member_id' => $this->request->getPost('member_id'),
            'book_id' => $this->request->getPost('book_id'),
            'reservation_date' => $this->request->getPost('reservation_date'),
            'status' => 'active',
        ];

        $this->reservationModel->save($data);

        $this->booksModel->update($this->request->getPost('book_id'), ['status' => 'reserved']);

        return redirect()->to('/admin/reservations')->with('success', 'Reservasi berhasil ditambahkan.');
    }

    public function complete($id)
    {
        $reservation = $this->reservationModel->find($id);

        if ($reservation && $reservation['status'] == 'active') {
            $this->reservationModel->update($id, ['status' => 'completed']);

            $this->loansModel->insert([
                'book_id' => $reservation['book_id'],
                'member_id' => $reservation['member_id'],
                'loan_date' => date('Y-m-d'),
                'due_date' => date('Y-m-d', strtotime('+7 days')) 
            ]);

            return redirect()->to('admin/reservations')->with('success', 'Reservation marked as completed and loan created.');
        }

        return redirect()->to('admin/reservations')->with('error', 'Invalid reservation or action.');
    }

    public function cancel($id)
    {
        $reservation = $this->reservationModel->find($id);

        if ($reservation && $reservation['status'] == 'active') {
            $this->reservationModel->update($id, ['status' => 'cancelled']);
            return redirect()->to('admin/reservations')->with('success', 'Reservation cancelled.');
        }

        return redirect()->to('admin/reservations')->with('error', 'Invalid reservation or action.');
    }
}
