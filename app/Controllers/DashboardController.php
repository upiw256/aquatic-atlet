<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        $role = session('role');

        switch ($role) {
            case 'admin':
                return redirect()->to('/admin/dashboard');
            case 'owner':
                return redirect()->to('/owner/dashboard');
            case 'member':
                return redirect()->to('/member/dashboard');
            default:
                return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
    }
}
