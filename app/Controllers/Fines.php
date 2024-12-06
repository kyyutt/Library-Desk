<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FinesModel;
use App\Models\MembersModel;
use App\Models\BooksModel;
use App\Models\LoansModel;

class Fines extends BaseController
{
    protected $finesModel;
    protected $membersModel;
    protected $booksModel;
    protected $loansModel;

    public function __construct()
    {
        $this->finesModel = new FinesModel();
        $this->membersModel = new MembersModel();
        $this->booksModel = new BooksModel();
        $this->loansModel = new LoansModel();
    }

    public function index()
    {
        $fines = $this->finesModel->where('status', 'unpaid')->findAll();

        foreach ($fines as &$fine) {
            $loan = $this->loansModel->find($fine['loan_id']);

            if ($loan) {
                $fine['member_id'] = $loan['member_id'];
                $fine['book_id'] = $loan['book_id'];
                $fine['loan_date'] = $loan['loan_date'];
                $fine['due_date'] = $loan['due_date']; // Mengambil due_date dari loan

                $member = $this->membersModel->find($fine['member_id']);
                $book = $this->booksModel->find($fine['book_id']);

                $fine['member_name'] = $member ? $member['name'] : 'Member not found';
                $fine['book_title'] = $book ? $book['title'] : 'Book not found';

                // Hitung jumlah hari keterlambatan
                $today = new \DateTime();
                $dueDate = new \DateTime($fine['due_date']);
                $lateDays = $today > $dueDate ? $today->diff($dueDate)->days : 0;

                $fine['late_days'] = $lateDays; // Menyimpan jumlah hari terlambat
            } else {
                $fine['member_name'] = 'Loan not found';
                $fine['book_title'] = 'Loan not found';
                $fine['loan_date'] = 'Loan not found';
                $fine['due_date'] = 'Loan not found';
                $fine['late_days'] = 0;
            }
        }

        $data['fines'] = $fines;
        return view('fines/index', $data);
    }


    public function pay($id)
    {
        $fine = $this->finesModel->find($id);

        if ($fine && $fine['status'] == 'unpaid') {
            $this->finesModel->update($id, ['status' => 'paid']);
            return redirect()->to('/fines')->with('success', 'Fine marked as paid.');
        }

        return redirect()->to('/fines')->with('error', 'Fine not found or already paid.');
    }
}
