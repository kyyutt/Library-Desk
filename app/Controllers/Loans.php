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
            $loan['member_name'] = !empty($member) ? reset($member)['name'] : 'Anggota tidak ditemukan';

            $book = array_filter($books, fn($b) => $b['id'] === $loan['book_id']);
            $loan['book_title'] = !empty($book) ? reset($book)['title'] : 'Buku tidak ditemukan';

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

        // Periksa apakah peminjaman sudah lewat tanggal jatuh tempo dan belum ada denda yang belum dibayar
        if ($loan['due_date'] < $today) {
            $fine = $this->finesModel->where('loan_id', $loan['id'])->orderBy('id', 'desc')->first();

            if ($fine && $fine['status'] === 'paid') {
                // Lewati jika catatan denda terakhir sudah dibayar
                return;
            }

            // Hitung hari keterlambatan
            $daysOverdue = (strtotime($today) - strtotime($loan['due_date'])) / (60 * 60 * 24);
            $fineAmount = $daysOverdue * $finePerDay;

            if (!$fine) {
                // Membuat catatan denda baru jika belum ada
                $this->finesModel->save([
                    'loan_id' => $loan['id'],
                    'fine_amount' => $fineAmount,
                    'status' => 'unpaid'
                ]);
                $this->loanModel->update($loan['id'], ['status' => 'Overdue']);
            } else {
                // Memperbarui catatan denda yang ada jika belum dibayar
                $this->finesModel->update($fine['id'], ['fine_amount' => $fineAmount]);
            }
        }
    }

    public function create()
    {
        $data['members'] = $this->membersModel->findAll();
        $data['books'] = $this->booksModel->findAvailableBooks(); // Menemukan buku yang tersedia untuk dipinjam

        return view('loans/create', $data);
    }

    public function store()
    {
        $loanDate = $this->request->getPost('loan_date');
        $dueDate = date('Y-m-d', strtotime($loanDate . ' + 7 days'));

        // Memastikan pengaturan denda yang aktif tersedia
        $fineSetting = $this->fineSettingsModel->where('is_active', 1)->first();

        if (!$fineSetting) {
            return redirect()->back()->with('error', 'Tidak ditemukan pengaturan denda yang aktif.');
        }

        // Menyiapkan data peminjaman
        $data = [
            'member_id' => $this->request->getPost('member_id'),
            'book_id' => $this->request->getPost('book_id'),
            'loan_date' => $loanDate,
            'due_date' => $dueDate,
            'return_date' => null,
            'fine_setting_id' => $fineSetting['id'],  // Memastikan menggunakan pengaturan denda yang aktif
            'status' => 'On Loan',
        ];

        // Menyimpan data peminjaman
        $this->loanModel->save($data);

        // Memperbarui status buku menjadi 'dipinjam'
        $this->booksModel->update($this->request->getPost('book_id'), ['status' => 'borrowed']);

        // Menangani reservasi
        $reservation = $this->reservationModel->where('book_id', $this->request->getPost('book_id'))
            ->where('status', 'active')
            ->first();

        if ($reservation) {
            // Menandai reservasi sebagai selesai
            $this->reservationModel->update($reservation['id'], ['status' => 'completed']);
        }

        return redirect()->to('/loans')->with('success', 'Peminjaman berhasil ditambahkan.');
    }

    public function returnLoan($id)
    {
        $loan = $this->loanModel->find($id);

        if (!$loan) {
            return redirect()->to('/loans')->with('error', 'Peminjaman tidak ditemukan.');
        }

        // Memeriksa apakah ada denda yang belum dibayar sebelum mengembalikan peminjaman
        $fine = $this->finesModel->where('loan_id', $id)->where('status', 'unpaid')->first();
        if ($fine) {
            return redirect()->to('/loans')->with('error', 'Tidak bisa mengembalikan peminjaman dengan denda yang belum dibayar.');
        }

        // Memperbarui informasi pengembalian peminjaman
        $this->loanModel->update($id, [
            'return_date' => date('Y-m-d'),
            'status' => 'Returned'  // Menandai status sebagai 'Dikembalikan'
        ]);

        // Memperbarui status buku menjadi 'tersedia' setelah dikembalikan
        $this->booksModel->update($loan['book_id'], ['status' => 'available']);

        return redirect()->to('/loans')->with('success', 'Peminjaman berhasil dikembalikan dan status diperbarui menjadi Dikembalikan.');
    }

    public function extendDueDate($loanId)
    {
        // Mencari peminjaman berdasarkan loanId
        $loan = $this->loanModel->find($loanId);

        if (!$loan) {
            return redirect()->to('/loans')->with('error', 'Peminjaman tidak ditemukan.');
        }

        $fine = $this->finesModel->where('loan_id', $loanId)->where('status', 'unpaid')->first();

        if ($fine) {
            return redirect()->to('/loans')->with('error', 'Silakan bayar denda sebelum memperpanjang tanggal jatuh tempo.');
        }

        // Memeriksa apakah pengaturan denda aktif (fine setting dengan is_active = 1)
        $fineSetting = $this->fineSettingsModel->where('is_active', 1)->first();

        if (!$fineSetting) {
            // Jika tidak ditemukan pengaturan denda aktif, tangani situasi ini
            return redirect()->to('/loans')->with('error', 'Tidak ditemukan pengaturan denda yang aktif.');
        }

        // Memperpanjang tanggal jatuh tempo dengan menambahkan 7 hari pada tanggal jatuh tempo saat ini
        $newDueDate = date('Y-m-d', strtotime($loan['due_date'] . ' +7 days'));

        // Memperbarui peminjaman dengan tanggal jatuh tempo baru dan menandainya sebagai 'Diperpanjang'
        $this->loanModel->update($loanId, [
            'due_date' => $newDueDate,
            'status' => 'Extended'
        ]);

        // Menampilkan pesan sukses dengan tanggal jatuh tempo yang baru
        return redirect()->to('/loans')->with('success', 'Tanggal jatuh tempo diperpanjang hingga ' . $newDueDate);
    }
}
