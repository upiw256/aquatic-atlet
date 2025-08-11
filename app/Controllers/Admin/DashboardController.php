<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BiodataModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Models\TeamModel;
use App\Models\TeamMemberModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $teamModel = new TeamModel();
        $biodata = new BiodataModel();
        // Cek apakah sudah isi biodata
        $userId = session('user_id');
        $biodata = $biodata->where('user_id', $userId)->first();
        if (!$biodata) {
            return redirect()->to('/member/profile')->with('warning', 'Anda harus mengisi biodata terlebih dahulu sebelum mengakses dashboard.');
        }
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
        $biodataTeamMemberModel = new TeamMemberModel();
        // Ambil query builder
        $builder = $userModel->getMembersWithTeam();

        // Ambil data paginated
        $members = $builder
            ->get()
            ->getResultArray();

        // dd($biodataTeamMemberModel);
        foreach ($members as &$member) {
            $member['team'] = $biodataTeamMemberModel->getTeamByMember($member['id']);
        }
        return view('admin/members', [
            'members' => $members,
        ]);
    }

    public function makeAdmin($id)
    {
        $userModel = new UserModel();
        $getTeamByMember = new TeamMemberModel();
        $user = $userModel->find($id);

        if (!$user) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'User tidak ditemukan',
            ])->setStatusCode(404);
        }
        // cek jika user sudah admin
        if ($getTeamByMember->getTeamByMember($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'User adalah atlit, tidak bisa dijadikan admin',
            ])->setStatusCode(400);
        }
        if ($user['role'] === 'admin') {
            $userModel->update($id, ['role' => 'member']);
            return $this->response->setJSON([
                'status' => 'success',
                'message' => $user['name'] . ' berhasil dijadikan member',
            ]);
        } else {

            $userModel->update($id, ['role' => 'admin']);
            return $this->response->setJSON([
                'status' => 'success',
                'message' => $user['name'] . ' berhasil dijadikan admin',
            ]);
        }
    }


    public function teams()
    {
        $teamModel = new TeamModel();
        $teamsRaw = $teamModel->getAllMembers(); // sudah pakai string_agg (PostgreSQL) atau group_concat (MySQL)

        $groupedTeams = [];

        foreach ($teamsRaw as $team) {
            $members = [];
            if (!empty($team['member_list'])) {
                $memberItems = explode('|', $team['member_list']);
                foreach ($memberItems as $item) {
                    list($mid, $mname, $memail, $mrole) = explode(':', $item);
                    $members[] = [
                        'id'    => $mid,
                        'name'  => $mname,
                        'email' => $memail,
                        'role'  =>  $mrole,// default role
                    ];
                }
            }

            $groupedTeams[] = [
                'id'           => $team['id'],
                'name'         => $team['name'],
                'description'  => $team['description'],
                'logo'         => $team['logo'],
                'owner_name'   => $team['owner_name'],
                'owner_email'  => $team['owner_email'],
                'member_count' => count($members),
                'members'      => $members
            ];
        }

        return view('admin/teams', [
            'teams' => $groupedTeams
        ]);
    }
    public function users()
    {
        $userModel = new UserModel();

        $data = [
            'users' => $userModel->getEligibleAdmins()
        ];
    
        return view('admin/users', $data);
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
    function generateRandomPassword($length = 12)
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        return substr(str_shuffle(str_repeat($chars, ceil($length / strlen($chars)))), 0, $length);
    }
    public function search()
    {
        $q = $this->request->getGet('q');
        if (strlen($q) < 3) {
            return $this->response->setJSON([]);
        }

        $users = new UserModel();
        $users = $users->like('name', $q)
            ->orLike('email', $q)
            ->findAll();

        return $this->response->setJSON($users);
    }
}
