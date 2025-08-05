<?php

namespace App\Controllers;

use App\Models\TeamModel;
use App\Models\TeamMemberModel;
use App\Models\UserModel;

class Home extends BaseController
{
    public function index(): string
    {
        $teamModel = new TeamModel();
        $teams = $teamModel->findAll();
        $data = [
            'teams' => $teams,
            'title' => 'Home',
        ];
        return view('welcome_message', $data);
    }
    public function teamDetail(string $slug): string
    {
        $teamModel = new TeamModel();
        $memberModel = new TeamMemberModel();
        $userModel = new UserModel();
        $team = $teamModel->where('id', $slug)->first();

        if (!$team) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Team with slug '$slug' not found.");
        }
        $owner = $userModel->find($team['owner_id']);
        $members = $memberModel->getMembersByTeam($team['id']);
        // dd($members);
        $team['members'] = $members;
        //cek jika owner tidak ada
        if (!$owner) {
            $owner = [
                'name' => 'Tidak ada owner',
                'email' => 'Tidak ada email',
            ];
        }
        $team['owner'] = $owner;

        $data = [
            'team' => $team,
            'title' => $team['name'],
        ];
        return view('team_detail', $data);
    }   
}
