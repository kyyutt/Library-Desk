<?php

namespace App\Models;

use CodeIgniter\Model;

class FineSettingsModel extends Model
{
    protected $table = 'fine_settings';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['fine_per_day', 'is_active'];
}
