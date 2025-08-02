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
        $userModel = new UserModel();
        $members = $userModel->getMembersWithTeam(); // atau pakai filter role
        return view('admin/members', ['members' => $members]);
    }

    public function teams()
    {
        $teamModel = new TeamModel();
        $teams = $teamModel->getTeamsWithOwner(); // kamu bisa custom join owner
        return view('admin/teams', ['teams' => $teams]);
    }
    public function users()
    {
        $userModel = new UserModel();
        $users = $userModel->findAll();
        return view('admin/users', ['users' => $users]);
    }

    public function usersReset($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'User tidak ditemukan',
            ])->setStatusCode(404);
        }

        // Generate password baru
        $newPassword = $this->generateRandomPassword(8);
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update password
        $userModel->update($id, ['password' => $hashedPassword]);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Password berhasil direset',
            'new_password' => $newPassword,
        ]);
    }
    function generateRandomPassword($length = 12) {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        return substr(str_shuffle(str_repeat($chars, ceil($length / strlen($chars)))), 0, $length);
    }
    
}
