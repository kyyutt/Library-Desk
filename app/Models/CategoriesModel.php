<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriesModel extends Model
{
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['category_name'];

    public function hasRelatedRecords($categoryId)
    {
        $relatedRecordsCount = $this->db->table('books')
            ->where('category_id', $categoryId)
            ->countAllResults();
        return $relatedRecordsCount > 0;
    }
}
