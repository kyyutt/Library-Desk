<?php

namespace App\Models;

use CodeIgniter\Model;

class BooksModel extends Model
{
    protected $table            = 'books';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['title', 'author', 'publisher', 'year', 'isbn', 'category_id', 'rack_id', 'status'];
    public function hasRelatedRecords($bookId)
{
    $loanExists = $this->db->table('loans')->where('book_id', $bookId)->countAllResults();

    $reservationExists = $this->db->table('reservations')->where('book_id', $bookId)->countAllResults();

    return $loanExists > 0 || $reservationExists > 0;
}
public function findAvailableBooks()
    {
        return $this->where('status', 'available')->findAll();
    }
}
