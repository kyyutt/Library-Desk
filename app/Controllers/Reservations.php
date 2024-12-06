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
            $reservation['member_name'] = !empty($member) ? reset($member)['name'] : 'Anggota tidak ditemukan';

            $book = array_filter($books, function ($b) use ($reservation) {
                return $b['id'] === $reservation['book_id'];
            });
            $reservation['book_title'] = !empty($book) ? reset($book)['title'] : 'Buku tidak ditemukan';
        }

        $data['reservations'] = $reservations;
        return view('reservations/index', $data);
    }

    public function create()
    {
        $loansModel = new LoansModel();
        $membersModel = new MembersModel();
        $booksModel = new BooksModel();

        // Mendapatkan pinjaman aktif (buku yang sedang dipinjam)
        $activeLoans = $loansModel->where('return_date', null)->findAll();

        // Mendapatkan semua buku
        $allBooks = $booksModel->findAll();

        // Mendapatkan ID buku yang dipinjam
        $borrowedBookIds = array_column($activeLoans, 'book_id');

        // Menyaring buku yang sedang dipinjam untuk mendapatkan buku yang tersedia
        if (!empty($borrowedBookIds)) {
            $availableBooks = $booksModel->whereNotIn('id', $borrowedBookIds)->findAll();
        } else {
            $availableBooks = $allBooks;  // Jika tidak ada buku yang dipinjam, semua buku tersedia
        }

        // Mendapatkan anggota yang tersedia (anggota yang belum meminjam buku)
        $borrowedMemberIds = array_column($activeLoans, 'member_id');
        if (!empty($borrowedMemberIds)) {
            $availableMembers = $membersModel->whereNotIn('id', $borrowedMemberIds)->findAll();
        } else {
            $availableMembers = $membersModel->findAll();
        }

        // Menambahkan informasi buku dan anggota ke pinjaman aktif
        foreach ($activeLoans as &$loan) {
            // Menambahkan nama anggota untuk setiap pinjaman
            $member = $membersModel->find($loan['member_id']);
            $loan['member_name'] = $member['name'];

            // Menambahkan judul buku untuk setiap pinjaman
            $book = $booksModel->find($loan['book_id']);
            $loan['book_title'] = $book['title'];
        }

        return view('reservations/create', [
            'availableBooks' => $availableBooks,  // Buku yang tersedia
            'activeLoans' => $activeLoans,        // Buku yang sedang dipinjam
            'availableMembers' => $availableMembers, // Anggota yang tersedia
            'reservationDate' => date('Y-m-d'),  // Tanggal saat ini untuk reservasi
        ]);
    }
    public function store()
    {
        // Langkah 1: Simpan data reservasi
        $data = [
            'member_id' => $this->request->getPost('member_id'),
            'book_id' => $this->request->getPost('book_id'),
            'reservation_date' => $this->request->getPost('reservation_date'),
            'status' => 'active', // Status awal reservasi
        ];
        $this->reservationModel->save($data);

        // Langkah 2: Perbarui status buku menjadi "reserved"
        $this->booksModel->update($this->request->getPost('book_id'), ['status' => 'reserved']);

        // Langkah 3: Periksa apakah buku saat ini "dipinjam"
        $loan = $this->loansModel
            ->where('book_id', $this->request->getPost('book_id'))
            ->where('status', 'On Loan')  // Memeriksa apakah buku saat ini dipinjam
            ->first();

        if ($loan) {
            // Jika buku dipinjam, perbarui status pinjaman menjadi "Reserved"
            $this->loansModel->update($loan['id'], ['status' => 'Reserved']);
        }

        // Langkah 4: Redirect kembali dengan pesan sukses
        return redirect()->to('/reservations')->with('success', 'Reservasi berhasil ditambahkan, dan status pinjaman diperbarui menjadi Reserved.');
    }

    public function complete($id)
    {
        // Langkah 1: Temukan catatan reservasi
        $reservation = $this->reservationModel->find($id);

        // Periksa apakah reservasi ada dan masih aktif
        if ($reservation && $reservation['status'] == 'active') {

            // Langkah 2: Dapatkan pinjaman aktif untuk buku dan anggota yang diberikan
            $existingLoan = $this->loansModel->where('book_id', $reservation['book_id'])
                ->where('status', 'Returned')
                ->first();

            if (!$existingLoan) {
                return redirect()->to('/reservations')->with('error', 'Buku belum dikembalikan.');
            }

            $this->reservationModel->update($id, ['status' => 'completed']);

            $fineSettingsModel = new \App\Models\FineSettingsModel();
            $activeFineSetting = $fineSettingsModel->where('is_active', 1)->first();

            if (!$activeFineSetting) {
                return redirect()->to('/reservations')->with('error', 'Tidak ditemukan pengaturan denda aktif.');
            }

            // Langkah 5: Masukkan catatan pinjaman baru
            $this->loansModel->insert([
                'book_id' => $reservation['book_id'],
                'member_id' => $reservation['member_id'],
                'loan_date' => date('Y-m-d'),
                'due_date' => date('Y-m-d', strtotime('+7 days')),
                'fine_setting_id' => $activeFineSetting['id'],  // Atur fine_setting_id
                'status' => 'On Loan'  // Atur status menjadi "On Loan"
            ]);

            // Redirect kembali dengan pesan sukses
            return redirect()->to('/reservations')->with('success', 'Reservasi ditandai sebagai selesai dan pinjaman baru dibuat.');
        }

        // Jika reservasi tidak valid atau tidak aktif
        return redirect()->to('/reservations')->with('error', 'Reservasi atau tindakan tidak valid.');
    }
    public function cancel($id)
    {
        $reservation = $this->reservationModel->find($id);

        if ($reservation && $reservation['status'] == 'active') {
            // Langkah 1: Perbarui status reservasi menjadi dibatalkan
            $this->reservationModel->update($id, ['status' => 'cancelled']);

            // Langkah 2: Periksa apakah ada pinjaman aktif yang terkait dengan buku reservasi
            $loan = $this->loansModel
                ->where('book_id', $reservation['book_id'])
                ->where('status', 'Reserved')  // Memeriksa apakah buku dalam status reserved
                ->first();

            if ($loan) {
                // Langkah 3: Jika pinjaman ditemukan, ubah statusnya menjadi 'On Loan'
                $this->loansModel->update($loan['id'], ['status' => 'On Loan']);
            }

            // Langkah 4: Redirect kembali dengan pesan sukses
            return redirect()->to('/reservations')->with('success', 'Reservasi dibatalkan dan status pinjaman diperbarui menjadi "On Loan".');
        }

        // Jika reservasi tidak valid atau tidak aktif
        return redirect()->to('/reservations')->with('error', 'Reservasi atau tindakan tidak valid.');
    }
}  
