<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Database\Migrations\TeamMembers;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Achivement;
use App\Models\TeamMemberModel;
use Ramsey\Uuid\Uuid;

class AchivementController extends BaseController
{
    public function index()
    {
        $achivementModel = new Achivement();

        // Ambil semua data prestasi (join dengan team_members, users, team)
        $achievementsRaw = $achivementModel->getAllAchievements();

        // Kelompokkan berdasarkan team_member_id
        $grouped = [];
        foreach ($achievementsRaw as $row) {
            $id = $row['team_member_id'];
            if (!isset($grouped[$id])) {
                $grouped[$id] = [
                    'team_member_id' => $id,
                    'member_name' => $row['member_name'],
                    'team_name' => $row['team_name'],
                    'achievements' => []
                ];
            }

            $grouped[$id]['achievements'][] = [
                'id' => $row['id'],
                'nama_kejuaraan' => $row['nama_kejuaraan'],
                'lokasi' => $row['lokasi'],
                'tingkat' => $row['tingkat'],
                'tahun' => $row['tahun'],
                'posisi_akhir' => $row['posisi_akhir'],
                'skor' => $row['skor']
            ];
        }

        $data = [
            'title' => 'Achievements',
            'active' => 'achievements',
            'achievements' => $grouped,
        ];

        return view('admin/achivement', $data);
    }

    public function create()
    {
        $member = new TeamMemberModel();
        $members = $member->getAllMembers();
        // dd($members);
        $data = [
            'title' => 'Create Achievement',
            'active' => 'achievements',
            'members' => $members,
        ];
        return view('admin/create_achievement', $data);
    }
    public function store()
    {
        $achivementModel = new Achivement();
        $data = [
            'id' => Uuid::uuid4()->toString(),
            'member_id' => $this->request->getVar('member_id'),
            'nama_kejuaraan' => $this->request->getVar('nama_kejuaraan'),
            'lokasi' => $this->request->getVar('lokasi'),
            'tingkat' => $this->request->getVar('tingkat'),
            'tahun' => $this->request->getVar('tahun'),
            'posisi_akhir' => $this->request->getVar('posisi_akhir'),
            'skor' => $this->request->getVar('score'),
        ];
        // dd($data);
        if ($achivementModel->insert($data)) {
            return redirect()->to(site_url('admin/achivements'))->with('success', 'Achievement created successfully');
        } else {
            return redirect()->back()->withInput()->with('errors', $achivementModel->errors());
        }
    }
}
