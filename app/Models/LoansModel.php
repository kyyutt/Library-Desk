<?php

namespace App\Models;

use CodeIgniter\Model;

class LoansModel extends Model
{
    protected $table            = 'loans';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields    = ['member_id', 'book_id', 'loan_date', 'due_date', 'return_date'];

    public function hasRelatedRecords($loanId)
    {
        // Check if the loan has any related fines
        $fineExists = $this->db->table('fines')->where('loan_id', $loanId)->countAllResults();

        // Check if the loan has any related reservations
        $reservationExists = $this->db->table('reservations')->where('loan_id', $loanId)->countAllResults();

        // Return true if there are any fines or reservations related to the loan
        return $fineExists > 0 || $reservationExists > 0;
    }
}
