<?php

namespace App\Models;

use CodeIgniter\Model;

class BookLogsModel extends Model
{
    protected $table            = 'booklogs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['book_id', 'admin_id', 'date', 'action'];

}
