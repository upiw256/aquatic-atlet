<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TeamModel;
use App\Models\UserModel;
use Ramsey\Uuid\Uuid;

class TeamController extends BaseController
{
    public function assignOwnerForm($userId)
    {
        $userModel = new UserModel();
        $teamModel = new TeamModel();

        $user = $userModel->find($userId);

        if (!$user || $user['role'] !== 'member') {
            return redirect()->to('/admin/members')->with('error', 'User tidak valid.');
        }

        // Ambil daftar tim yang belum punya owner
        $availableTeams = $teamModel->where('owner_id', null)->findAll();
        // dd($availableTeams);
        return view('admin/assign_owner', [
            'user' => $user,
            'teams' => $availableTeams,
        ]);
    }

    public function assignOwner($userId)
    {
        $teamModel = new TeamModel();
        $userModel = new UserModel();

        $teamId = $this->request->getPost('team_id');
        // $userId = $this->request->getPost('user_id');

        // Ambil data tim dari pilihan form
        $team = $teamModel->find($teamId);
        if (!$team) {
            return redirect()->back()->with('error', 'Tim tidak ditemukan.');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // Jika tim sudah punya owner, jadikan role-nya member
        if (!empty($team['owner_id'])) {
            $userModel->update($team['owner_id'], ['role' => 'member']);
        }

        // Update tim dengan owner baru (user id dari URL)
        $teamModel->update($teamId, ['owner_id' => $userId]);

        // Update user role jadi owner
        $userModel->update($userId, ['role' => 'owner']);

        $db->transComplete();

        return redirect()->to('/admin/teams')->with('success', 'Owner berhasil diperbarui.');
    }

    public function create()
    {
        $userModel = new UserModel();
        $owners = $userModel->where('role', 'member')->findAll();

        return view('admin/teams/create', [
            'owners' => $owners
        ]);
    }

    public function store()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'name' => 'required|min_length[3]',
            'owner_id' => 'permit_empty|is_not_unique[users.id]',
            'description' => 'permit_empty|min_length[10]',
        ];
        $owners = $this->request->getPost('owner_id');
        $owners = $owners === '' ? null : $owners;

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode(', ', $validation->getErrors()));
        }

        $teamModel = new TeamModel();
        $userModel = new UserModel();
        $teamModel->insert([
            'id'          => Uuid::uuid4()->toString(),
            'name' => $this->request->getPost('name'),
            'owner_id' => $owners,
            'description' => $this->request->getPost('description'),
        ]);
        // Jika ada owner yang dipilih, update role-nya jadi owner
        if ($owners) {
            $user = $userModel->find($owners);
            if ($user) {
                $userModel->update($owners, ['role' => 'owner']);
            }
        }

        return redirect()->to('/admin/teams')->with('success', 'Tim berhasil ditambahkan!');
    }
}
