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

}
