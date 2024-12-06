<?php

namespace App\Models;

use CodeIgniter\Model;

class EbookModel extends Model
{
    protected $table            = 'ebooks';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['title', 'author', 'publisher', 'year_of_publication', 'isbn', 'description', 'category_id', 'file_name', 'file_size', 'status'];
}
