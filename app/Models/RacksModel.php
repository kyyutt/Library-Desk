<?php

namespace App\Models;

use CodeIgniter\Model;

class RacksModel extends Model
{
    protected $table            = 'racks';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['rack_number'];

    public function hasRelatedRecords($rackId) {
        // Check if there are books associated with this category
        $relatedRecordsCount = $this->db->table('books') // Adjust this to your actual books table
                                          ->where('rack_id', $rackId) // Adjust this to your actual foreign key field
                                          ->countAllResults();

        // Return true if there are related records, false otherwise
        return $relatedRecordsCount > 0;
    }

}
