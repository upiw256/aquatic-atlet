<?php

namespace App\Models;

use CodeIgniter\Model;

class Achivement extends Model
{
    protected $table            = 'achivements';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $allowedFields    = ['id', 'member_id', 'nama_kejuaraan', 'lokasi', 'tingkat', 'tahun', 'posisi_akhir', 'skor', 'created_at', 'updated_at'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    public function getAchivementsByMember($memberId)
    {
        return $this->where('member_id', $memberId)->findAll();
    }
    public function getByMemberId($memberId)
    {
        return $this->select('
                achivements.*,
                users.name AS member_name,
                teams.name AS team_name
            ')
            ->join('team_members', 'team_members.id = achivements.member_id')
            ->join('users', 'users.id = team_members.member_id')
            ->join('teams', 'teams.id = team_members.team_id')
            ->where('achivements.id', $memberId)
            ->findAll();
    }
    public function getAllAchievements()
    {
        return $this->select('achivements.id, achivements.nama_kejuaraan, achivements.lokasi, achivements.tingkat, achivements.tahun, achivements.posisi_akhir, achivements.skor, team_members.id as team_member_id, users.name as member_name, teams.name as team_name')
            ->join('team_members', 'team_members.id = achivements.member_id')
            ->join('users', 'users.id = team_members.member_id')
            ->join('teams', 'teams.id = team_members.team_id')
            ->orderBy('users.name')
            ->findAll();
    }
    public function getMemberByUserid($userId)
    {
        return $this->select('
                achivements.*,
                users.name AS member_name,
                teams.name AS team_name
            ')
            ->join('team_members', 'team_members.id = achivements.member_id')
            ->join('users', 'users.id = team_members.member_id')
            ->join('teams', 'teams.id = team_members.team_id')
            ->where('users.id', $userId)
            ->findAll();
    }
}
