<?php

namespace App\Controllers\Inspector;

use App\Controllers\BaseController;
use App\Models\BiodataModel;
use App\Models\TeamModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

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
        return view('inspector/dashboard', [
            'memberCount' => $memberCount,
            'teamCount' => $teamCount
        ]);
    }
}
