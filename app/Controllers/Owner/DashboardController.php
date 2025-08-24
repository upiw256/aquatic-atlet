<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use App\Models\TeamMemberModel;
use App\Models\TeamModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use Ramsey\Uuid\Uuid;
use App\Models\BiodataModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $userId = session('user_id');

        $teamModel = new TeamModel();
        $teamMemberModel = new TeamMemberModel();
        $userModel = new UserModel();
        $biodataModel = new BiodataModel();
        // cek apakah sudah isi biodata jika belum redirect ke biodata
        $biodata = $biodataModel->where('user_id', $userId)->first();
        if (!$biodata) {
            return redirect()->to('/member/profile')->with('warning', 'Anda harus mengisi biodata terlebih dahulu sebelum mengakses dashboard.');
        }

        $team = $teamModel->getTeamByOwnerId($userId);

        $members = $team ? $teamMemberModel->getMembersByTeam($team['id']) : [];

        // Ambil user dengan role member yang belum tergabung di tim manapun
        $availableMembers = $userModel->where('role', 'member')
            ->whereNotIn('id', function ($builder) {
                return $builder->select('member_id')->from('team_members');
            })->findAll();

        return view('owner/dashboard', [
            'team' => $team,
            'members' => $members,
            'availableMembers' => $availableMembers,
        ]);
    }
    public function addMember()
    {
        $userId = session('user_id');
        $teamModel = new TeamModel();
        $teamMemberModel = new TeamMemberModel();

        $team = $teamModel->getTeamByOwnerId($userId);
        if (!$team) {
            return redirect()->back()->with('error', 'Tim tidak ditemukan.');
        }

        $memberId = $this->request->getPost('user_id');

        // Validasi agar member belum masuk tim lain
        $exists = $teamMemberModel->where('member_id', $memberId)->countAllResults();
        if ($exists) {
            return redirect()->back()->with('error', 'Member sudah tergabung dalam tim lain.');
        }

        $teamMemberModel->insert([
            'id'        => Uuid::uuid4()->toString(),
            'team_id'   => $team['id'],
            'member_id' => $memberId,
            'role'      => 'atlet',
            'status'    => 'pending',
        ]);
        // Update role user menjadi 'atlet'
        $userModel = new UserModel();
        $userModel->update($memberId, ['role' => 'atlet']);

        return redirect()->to('/owner/dashboard')->with('success', 'Anggota berhasil ditambahkan.');
    }
    public function updateRole()
    {
        $teamMemberModel = new \App\Models\TeamMemberModel();
        $memberId = $this->request->getPost('member_id');
        $role = $this->request->getPost('role');

        if (!$memberId || !$role) {
            return redirect()->back()->with('error', 'Data tidak lengkap.');
        }

        $teamMemberModel->update($memberId, ['role' => $role]);

        return redirect()->to('/owner/dashboard')->with('success', 'Peran anggota berhasil diperbarui.');
    }
    public function removeMember()
    {
        $memberId = $this->request->getPost('member_id');
        if (!$memberId) {
            return redirect()->back()->with('error', 'ID anggota tidak valid.');
        }

        $teamMemberModel = new \App\Models\TeamMemberModel();

        $deleted = $teamMemberModel->delete($memberId);
        if ($deleted) {
            return redirect()->to('/owner/dashboard')->with('success', 'Anggota berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus anggota.');
        }
    }
    public function edit($id)
    {
        $teamModel = new TeamModel();
        $team = $teamModel->find($id);
        //dd(session('id'));
        if (!$team || $team['owner_id'] !== session('user_id')) {
            return redirect()->to('/owner/dashboard')->with('error', 'Tim tidak ditemukan atau bukan milik Anda.');
        }

        return view('owner/edit_team', ['team' => $team]);
    }

    public function update($id)
    {
        $teamModel = new TeamModel();
        $team = $teamModel->find($id);

        if (!$team || $team['owner_id'] !== session('id')) {
            return redirect()->to('/owner/dashboard')->with('error', 'Tim tidak valid.');
        }

        $data = $this->request->getPost();

        $teamModel->update($id, [
            'name' => $data['name'],
            'description' => $data['description']
        ]);

        return redirect()->to('/owner/dashboard')->with('success', 'Data tim berhasil diperbarui.');
    }
}
