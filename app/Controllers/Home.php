<?php

namespace App\Controllers;

use App\Models\TeamModel;

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
}
