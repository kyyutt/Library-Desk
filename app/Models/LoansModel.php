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
}
