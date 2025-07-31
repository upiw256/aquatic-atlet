<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Models\TeamModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $teamModel = new TeamModel();
        $memberCount = $userModel->where('role', 'member')->countAllResults();
        $teamCount   = $teamModel->countAllResults();
        return view('admin/dashboard', [
            'memberCount' => $memberCount,
            'teamCount' => $teamCount
        ]);
    }
    public function members()
    {
        $userModel = new \App\Models\UserModel();
        $members = $userModel->getMembersWithTeam(); // atau pakai filter role
        return view('admin/members', ['members' => $members]);
    }

    public function teams()
    {
        $teamModel = new \App\Models\TeamModel();
        $teams = $teamModel->getTeamsWithOwner(); // kamu bisa custom join owner
        return view('admin/teams', ['teams' => $teams]);
    }
    
}
