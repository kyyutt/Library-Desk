<?php

namespace App\Models;

use CodeIgniter\Model;

class LoansModel extends Model
{
    protected $table            = 'loans';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields    = ['member_id', 'book_id', 'loan_date', 'due_date', 'return_date', 'fine_setting_id', 'status'];

    public function hasRelatedRecords($loanId)
    {
        $fineExists = $this->db->table('fines')->where('loan_id', $loanId)->countAllResults();

        $reservationExists = $this->db->table('reservations')->where('loan_id', $loanId)->countAllResults();

        return $fineExists > 0 || $reservationExists > 0;
    }

    public function getLoansWithDetails()
    {
        return $this->select('loans.*, members.name as member_name, books.title as book_title, fines.fine_amount, fines.status as fine_status')
            ->join('members', 'loans.member_id = members.id')
            ->join('books', 'loans.book_id = books.id')
            ->join('fines', 'loans.id = fines.loan_id', 'left') // ini left join untuk pinjaman yang belum memiliki denda
            ->findAll();
    }

    public function getLoansWithDetailsFiltered($startDate, $endDate)
    {
        return $this->select('loans.*, members.name as member_name, books.title as book_title, fines.fine_amount, fines.status as fine_status')
            ->join('members', 'loans.member_id = members.id')
            ->join('books', 'loans.book_id = books.id')
            ->join('fines', 'loans.id = fines.loan_id', 'left')
            ->where('loan_date >=', $startDate) // Filter ini berdasarkan tanggal mulai
            ->where('loan_date <=', $endDate) // Filter inik berdasarkan tanggal akhir
            ->findAll();
    }
    public function getLoansByMember($memberId)
    {
        return $this->select('loans.*, books.title AS book_title, members.name AS member_name')
            ->join('books', 'books.id = loans.book_id')
            ->join('members', 'members.id = loans.member_id')
            ->where('members.id', $memberId)
            ->findAll();
    }
}
