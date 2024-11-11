<?php

namespace App\Models;

use CodeIgniter\Model;

class LoansModel extends Model
{
    protected $table            = 'loans';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields    = ['member_id', 'book_id', 'loan_date', 'due_date', 'return_date', 'status'];

    public function hasRelatedRecords($loanId)
    {
        // Check if the loan has any related fines
        $fineExists = $this->db->table('fines')->where('loan_id', $loanId)->countAllResults();

        // Check if the loan has any related reservations
        $reservationExists = $this->db->table('reservations')->where('loan_id', $loanId)->countAllResults();

        // Return true if there are any fines or reservations related to the loan
        return $fineExists > 0 || $reservationExists > 0;
    }

    // Fetch loans with member names, book titles, and fine details
    public function getLoansWithDetails()
    {
        return $this->select('loans.*, members.name as member_name, books.title as book_title, fines.fine_amount, fines.status as fine_status')
                    ->join('members', 'loans.member_id = members.id')
                    ->join('books', 'loans.book_id = books.id')
                    ->join('fines', 'loans.id = fines.loan_id', 'left') // Left join to include loans without fines
                    ->findAll();
    }

}
