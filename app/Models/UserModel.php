<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';
    public    $useAutoIncrement = false;

    protected $returnType     = 'array';
    protected $useTimestamps  = true;

    protected $allowedFields = [
        'id', 'name', 'email', 'password', 'role', 'created_at', 'updated_at'
    ];

    public function getMembersWithTeam()
    {
    return $this->db->table('users u')
        ->select('u.*, t.name AS team_name')
        ->join('teams t', 't.owner_id = u.id', 'left')
        ->where('u.role !=', 'admin');
    }
}
