<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class LoginController extends BaseController
{
    public function index()
    {
        return view('login');
    }

    public function authenticate()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new \App\Models\UserModel();
        $user = $userModel->where('email', $email)->first();
        $isVerified = ($user['is_verified'] === true || $user['is_verified'] === 1 || $user['is_verified'] === 't');

        if (! $user || ! password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Email atau password salah!');
        }
        if (! $isVerified && $user['email_verified_at'] === null) {
            return redirect()->back()->withInput()->with('error', 'Akun Anda belum aktif. Silakan cek email untuk verifikasi.');
        }
        if ($user['role']=== 'atlet') {
            $role = 'member'; // Ganti role atlet menjadi member
        }else {
            $role = $user['role'];
        }

        session()->set([
            'user_id'   => $user['id'],
            'name'      => $user['name'],
            'email'     => $user['email'],
            'role'      => $role,
            'logged_in' => true,
        ]);

        // Redirect ke dashboard berdasarkan role
        if ($user['role'] === 'admin') {
            return redirect()->to('/admin/dashboard')->with('success', 'Selamat datang, Admin!');
        } elseif ($user['role'] === 'owner') {
            return redirect()->to('/owner/dashboard')->with('success', 'Selamat datang, Owner!');
        } elseif ($user['role'] === 'inspector') {
            return redirect()->to('/inspector/dashboard')->with('success', 'Selamat datang, inspector!');
        } else {
            return redirect()->to('/member/dashboard')->with('success', 'Selamat datang, Member!');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Berhasil logout.');
    }
}
