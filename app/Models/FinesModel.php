<?php

namespace App\Models;

use CodeIgniter\Model;

class FinesModel extends Model
{
    protected $table            = 'fines';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['loan_id', 'fine_amount', 'fine_setting', 'status'];
}

