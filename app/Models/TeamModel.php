<?php

namespace App\Models;

use CodeIgniter\Model;

class TeamModel extends Model
{
    protected $table      = 'teams';
    protected $primaryKey = 'id';
    public    $useAutoIncrement = false;

    protected $returnType     = 'array';
    protected $useTimestamps  = true;

    protected $allowedFields = [
        'id',
        'name',
        'description',
        'owner_id',
        'created_at',
        'updated_at',
        'logo',
    ];

    public function getTeamsWithOwner()
    {
        return $this->select('teams.*, users.name AS owner_name, users.email AS owner_email, COUNT(team_members.id) AS member_count')
            ->join('users', 'users.id = teams.owner_id', 'left')
            ->join('team_members', 'team_members.team_id = teams.id', 'left')
            ->groupBy('teams.id, users.name, users.email')
            ->findAll();
    }
    public function getTeamByOwnerId($ownerId)
    {
        return $this->where('owner_id', $ownerId)->first();
    }
}
