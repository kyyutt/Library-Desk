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

    public function hasRelatedRecords($categoryId) {
        // Check if there are books associated with this category
        $relatedRecordsCount = $this->db->table('books') // Adjust this to your actual books table
                                          ->where('category_id', $categoryId) // Adjust this to your actual foreign key field
                                          ->countAllResults();

        // Return true if there are related records, false otherwise
        return $relatedRecordsCount > 0;
    }

}
