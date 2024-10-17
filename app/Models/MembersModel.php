<?php

namespace App\Models;

use CodeIgniter\Model;

class MembersModel extends Model
{
    protected $table            = 'members';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['name', 'email', 'phone', 'address', 'membership_date'];

}
