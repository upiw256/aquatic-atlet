<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use Ramsey\Uuid\Uuid;
use Config\Services;

class RegisterController extends BaseController
{
    public function index()
    {
        return view('register');
    }

    public function store()
    {
        $verificationToken = bin2hex(random_bytes(32));
        $rules = [
            'name'     => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'confirm'  => 'required|matches[password]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $userModel->insert([
            'id'       => Uuid::uuid4()->toString(),
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'member',
            'is_verified'        => false,
            'verification_token' => $verificationToken,
        ]);
        $this->sendVerificationEmail($this->request->getPost('email'), $verificationToken);

        return redirect()->to('/login')->with('success', 'Registrasi berhasil. Silakan cek email Anda untuk verifikasi.');
    }
    private function sendVerificationEmail($email, $token)
    {
        $emailService = Services::email();

        $emailService->setFrom('no-reply@example.com', 'Aplikasi');
        $emailService->setTo($email);
        $emailService->setSubject('Verifikasi Email');
        $emailService->setMessage(
            'Klik link berikut untuk verifikasi akun Anda: ' .
                base_url("verify-email/{$token}")
        );

        if (! $emailService->send()) {
            log_message('error', 'Gagal mengirim email verifikasi ke ' . $email);
        }
    }

    public function verify($token)
    {
        $userModel = new UserModel();
        $user = $userModel->where('verification_token', $token)->first();

        if ($user) {
            $userModel->update($user['id'], [
                'is_verified'        => true,
                'email_verified_at'  => date('Y-m-d H:i:s'),
                'verification_token' => null,
            ]);

            return redirect()->to('/login')->with('success', 'Email berhasil diverifikasi. Silakan login.');
        }

        return redirect()->to('/login')->with('error', 'Token verifikasi tidak valid.');
    }

    public function resendVerification()
    {
        $email = $this->request->getPost('email');

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if (! $user) {
            return redirect()->back()->with('error', 'Email tidak ditemukan.');
        }

        if ($user['is_verified'] === true) {
            return redirect()->back()->with('success', 'Akun Anda sudah aktif.');
        }

        // Generate token baru
        $token = bin2hex(random_bytes(32));
        $userModel->update($user['id'], ['verification_token' => $token]);

        // Kirim email verifikasi lagi
        $this->sendVerificationEmail($email, $token);

        return redirect()->back()->with('success', 'Email verifikasi telah dikirim ulang.');
    }
    public function resendVerificationForm()
    {
        return view('resend_email');
    }
}
