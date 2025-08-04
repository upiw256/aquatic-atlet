<?php

namespace App\Models;

use CodeIgniter\Model;

class TeamMemberModel extends Model
{
    protected $table      = 'team_members';
    protected $primaryKey = 'id';
    public    $useAutoIncrement = false;

    protected $returnType     = 'array';
    protected $useTimestamps  = false;

    protected $allowedFields = [
        'id',
        'team_id',
        'member_id',
        'role',
        'status',
        'created_at'
    ];
    public function getTeamByMember($userId)
    {
        return $this->db->table('team_members')
            ->select('teams.*, users.name AS owner_name, users.email AS owner_email')
            ->join('teams', 'teams.id = team_members.team_id')
            ->join('users', 'users.id = teams.owner_id', 'left')
            ->where('team_members.member_id', $userId)
            ->get()
            ->getRowArray();
    }

    public function getMembersByTeam($teamId)
    {
        return $this->db->table($this->table)
        ->select('u.*, b.*, team_members.id AS team_member_id, team_members.role AS role, team_members.status AS status')
        ->join('users u', 'u.id = team_members.member_id')
        ->join('biodata b', 'b.user_id = u.id', 'left')
        ->where('team_members.team_id', $teamId)
        ->get()
        ->getResultArray();
    }
    public function isMemberInTeam($teamId, $memberId)
    {
        return $this->where('team_id', $teamId)
            ->where('member_id', $memberId)
            ->countAllResults() > 0;
    }
}
