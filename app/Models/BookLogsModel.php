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

    // You can add custom methods to filter the logs
    public function getLogsByBookId($book_id)
    {
        return $this->where('book_id', $book_id)->findAll();
    }

    public function getLogsByDateRange($start_date, $end_date)
    {
        return $this->where('date >=', $start_date)
                    ->where('date <=', $end_date)
                    ->findAll();
    }

    public function getAllLogs()
    {
        return $this->findAll();
    }
}
