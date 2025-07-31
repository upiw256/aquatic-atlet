<?php

namespace App\Controllers\Member;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\TeamMemberModel;
use App\Models\TeamModel;
use App\Models\BiodataModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $userId = session('user_id');
        $biodataModel = new BiodataModel();
        $biodata = $biodataModel->where('user_id', $userId)->first();

        $userModel = new UserModel();
        $teamModel = new TeamModel();
        $teamMemberModel = new TeamMemberModel();

        // Data user
        $user = $userModel->find($userId);

        // Ambil tim aktif (yang status = accepted)
        $acceptedTeamMember = $teamMemberModel
            ->where('member_id', $userId)
            ->where('status', 'accepted')
            ->first();

        $team = null;
        $members = [];

        if ($acceptedTeamMember) {
            // Dapatkan detail tim
            $team = $teamModel->find($acceptedTeamMember['team_id']);

            // Tambahkan informasi owner
            if ($team && $team['owner_id']) {
                $owner = $userModel->find($team['owner_id']);
                $team['owner_name']  = $owner['name'] ?? null;
                $team['owner_email'] = $owner['email'] ?? null;
            }

            // Ambil anggota lain di tim
            $memberRows = $teamMemberModel
                ->where('team_id', $team['id'])
                ->where('status', 'accepted')
                ->findAll();

            foreach ($memberRows as $m) {
                $memberUser = $userModel->find($m['member_id']);
                if ($memberUser) {
                    $members[] = [
                        'name'  => $memberUser['name'],
                        'email' => $memberUser['email'],
                        'role'  => $m['role'],
                    ];
                }
            }
        }

        // Ambil pending invites
        $pendingInvites = $teamMemberModel
            ->where('member_id', $userId)
            ->where('status', 'pending')
            ->findAll();

        return view('member/dashboard', [
            'user'          => $user,
            'team'          => $team,
            'members'       => $members,
            'pendingInvites' => $pendingInvites,
            'teamModel'     => $teamModel,
            'biodata'       => $biodata,
            'title'         => 'Dashboard',
        ]);
    }
    public function acceptInvite($teamMemberId)
    {
        $teamMemberModel = new TeamMemberModel();
        $userId = session('user_id');

        // Ambil data undangan
        $invite = $teamMemberModel->find($teamMemberId);
        if (!$invite || $invite['member_id'] !== $userId) {
            return redirect()->back()->with('error', 'Undangan tidak valid.');
        }

        // Cari tim lama (yang status accepted)
        $currentTeam = $teamMemberModel
            ->where('member_id', $userId)
            ->where('status', 'accepted')
            ->first();

        // Jika sudah tergabung di tim lain, hapus
        if ($currentTeam) {
            $teamMemberModel->delete($currentTeam['id']);
        }

        // Update status undangan menjadi accepted
        $teamMemberModel->update($teamMemberId, ['status' => 'accepted']);

        return redirect()->to('/member/dashboard')->with('success', 'Anda berhasil bergabung dengan tim baru.');
    }
    public function rejectInvite($teamMemberId)
    {
        $teamMemberModel = new \App\Models\TeamMemberModel();
        $userId = session('user_id');

        // Ambil data undangan
        $invite = $teamMemberModel->find($teamMemberId);
        if (!$invite || $invite['member_id'] !== $userId) {
            return redirect()->back()->with('error', 'Undangan tidak valid.');
        }

        // Update status undangan menjadi rejected
        $teamMemberModel->update($teamMemberId, ['status' => 'rejected']);

        return redirect()->to('/member/dashboard')->with('success', 'Undangan berhasil ditolak.');
    }
    public function leaveTeam()
    {
        $teamMemberModel = new \App\Models\TeamMemberModel();
        $userId = session('user_id');

        // Cari tim accepted
        $currentTeam = $teamMemberModel
            ->where('member_id', $userId)
            ->where('status', 'accepted')
            ->first();

        if ($currentTeam) {
            $teamMemberModel->delete($currentTeam['id']);
            return redirect()->to('/member/dashboard')->with('success', 'Anda telah keluar dari tim.');
        }

        return redirect()->back()->with('error', 'Tidak ditemukan tim yang sedang diikuti.');
    }
}
