<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Restful\ResourceController;
use App\Models\UserModel;

class AuthController extends ResourceController
{
    public function index()
    {
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Welcome to the API authentication endpoint.'
        ]);
    }
    public function login()
    {
        // Pastikan hanya menerima metode POST
        if ($this->request->getMethod() !== 'POST') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid request method.'
            ])->setStatusCode(ResponseInterface::HTTP_METHOD_NOT_ALLOWED);
        }

        // Ambil data dari POST form atau JSON
        $data = $this->request->getPost();
        if (empty($data)) {
            // Coba ambil dari JSON jika tidak ada di post
            $data = (array) $this->request->getJSON(true);
        }

        // Validasi input
        if (empty($data['email']) || empty($data['password'])) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Username and password are required.'
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        // Cek user di database
        $modelUser = new UserModel();
        $user = $modelUser->where('email', $data['email'])->first();

        if (!$user || !password_verify($data['password'], $user['password'])) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid username or password.'
            ])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }

        // Simpan session
        session()->set([
            'user_id' => $user['id'],
            'email' => $user['email'],
            'name' => $user['name'],
            'verification_token' => $user['verification_token'] ?? null,
            'is_verified' => $user['is_verified'] === 't' ? true : false,
            'role' => $user['role'],
        ]);

        // Kirim response sukses
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'User logged in successfully.',
            'user' => [
                'id' => $user['id'],
                'email' => $user['email'],
                'name' => $user['name'],
                'verification_token' => $user['verification_token'] ?? null,
                'is_verified' => $user['is_verified'] === 't' ? true : false,
                'role' => $user['role']
            ]
        ]);
    }

    public function register()
    {
        // Logic for user registration
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'User registered successfully.'
        ]);
    }
}
