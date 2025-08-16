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
    public function getAllMembers()
    {
        return $this->select("
        teams.id,
        teams.name,
        teams.description,
        teams.logo,
        owner.name AS owner_name,
        owner.email AS owner_email,
        string_agg(
                members.id || ':' || members.name || ':' || members.email || ':' || COALESCE(team_members.role, ''),
                '|'
            ) AS member_list
        ")
            ->join('users AS owner', 'owner.id = teams.owner_id', 'left')
            ->join('team_members', 'team_members.team_id = teams.id', 'left')
            ->join('users AS members', 'members.id = team_members.member_id', 'left')
            ->groupBy('teams.id, owner.name, owner.email')
            ->findAll();
    }


    public function getTeamByOwnerId($ownerId)
    {
        return $this->select('teams.*, users.name AS owner_name, users.email AS owner_email')
            ->join('users', 'users.id = teams.owner_id', 'left')
            ->where('teams.owner_id', $ownerId)
            ->first();
    }

    public function getMemberByTeamId($teamId)
    {
        return $this->db->table('team_members')
            ->select('team_members.*, users.name, users.email, biodata.gender, biodata.birth_date, biodata.birth_place, biodata.photo')
            ->join('users', 'users.id = team_members.member_id', 'left')
            ->join('biodata', 'biodata.user_id = users.id', 'left')
            ->where('team_members.team_id', $teamId)
            ->get()
            ->getResultArray();
    }
}
