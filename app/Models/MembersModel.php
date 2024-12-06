<?php

namespace App\Models;

use CodeIgniter\Model;

class MembersModel extends Model
{
    protected $table            = 'members';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['no_member', 'name', 'email', 'phone', 'address', 'membership_date', 'status', 'photo'];
    public function hasRelatedRecords($memberId)
    {
        // Check if the member has any related loans
        $loanExists = $this->db->table('loans')->where('member_id', $memberId)->countAllResults();

        // Check if the member has any related reservations
        $reservationExists = $this->db->table('reservations')->where('member_id', $memberId)->countAllResults();

        // Return true if the member has any loans or reservations
        return $loanExists > 0 || $reservationExists > 0;
    }
}
