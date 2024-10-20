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

    public function __construct()
    {
        $this->reservationModel = new ReservationModel();
        $this->booksModel = new BooksModel();
        $this->membersModel = new MembersModel();
    }

    public function index()
    {
        // Fetch all reservations
        $reservations = $this->reservationModel->findAll();

        // Fetch all books and members to associate with the reservations
        $books = $this->booksModel->findAll();
        $members = $this->membersModel->findAll();

        // Modify reservations to include book titles and member names
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

        // Ambil data peminjaman yang aktif (yang belum dikembalikan)
        $activeLoans = $loansModel->where('return_date', null)->findAll();

        // Ambil nama anggota dan judul buku untuk peminjaman aktif
        foreach ($activeLoans as &$loan) {
            $member = $membersModel->find($loan['member_id']);
            $loan['member_name'] = $member['name']; // Menyimpan nama anggota
            $book = $booksModel->find($loan['book_id']);
            $loan['book_title'] = $book['title']; // Menyimpan judul buku
        }

        // Ambil semua anggota untuk dropdown
        $members = $membersModel->findAll();

        return view('reservations/create', [
            'activeLoans' => $activeLoans,
            'members' => $members, // Ambil semua anggota
            'books' => $booksModel->findAll() // Ambil semua buku
        ]);
    }

    public function store()
    {
        $data = [
            'member_id' => $this->request->getPost('member_id'), // Mengisi member_id dari form
            'book_id' => $this->request->getPost('book_id'), // Mengisi book_id dari form
            'reservation_date' => $this->request->getPost('reservation_date'),
        ];

        $reservationModel = new \App\Models\ReservationModel();
        $reservationModel->save($data);

        return redirect()->to('/admin/reservations')->with('success', 'Reservasi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        // Find the specific reservation
        $data['reservation'] = $this->reservationModel->find($id);

        // Pass books and members to the view to edit the reservation
        $data['books'] = $this->booksModel->findAll();
        $data['members'] = $this->membersModel->findAll();

        return view('reservations/edit', $data);
    }

    public function update($id)
    {
        // Update reservation status
        $status = $this->request->getPost('status');
        $this->reservationModel->update($id, [
            'status' => $status,
            'book_id' => $this->request->getPost('book_id'),
            'member_id' => $this->request->getPost('member_id'),
        ]);

        // Update the book's status based on the reservation status
        $bookId = $this->request->getPost('book_id');

        if ($status === 'active') {
            // If reservation is active, set book status to 'reserved'
            $this->booksModel->update($bookId, ['status' => 'reserved']);
        } elseif ($status === 'cancelled' || $status === 'completed') {
            // If reservation is cancelled or completed, set book status to 'available'
            $this->booksModel->update($bookId, ['status' => 'available']);
        }

        return redirect()->to('admin/reservations');
    }

    public function delete($id)
    {
        // Find the reservation before deleting to get the book_id
        $reservation = $this->reservationModel->find($id);

        if ($reservation) {
            // Set the book status back to 'available' when deleting a reservation
            $this->booksModel->update($reservation['book_id'], ['status' => 'available']);
        }

        $this->reservationModel->delete($id);
        return redirect()->to('admin/reservations');
    }
}
