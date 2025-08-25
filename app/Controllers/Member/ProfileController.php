<?php

namespace App\Controllers\Member;

use App\Controllers\BaseController;
use App\Models\BiodataModel;
use App\Models\UserModel;
use Ramsey\Uuid\Uuid;
use Config\Services;
use Aws\S3\S3Client;

class ProfileController extends BaseController
{
    protected $s3;

    public function __construct()
    {
        $this->s3 = new S3Client([
            'version'                 => 'latest',
            'region'                  => getenv('R2_REGION') ?: 'auto',
            'endpoint'                => getenv('R2_ENDPOINT'), // HARUS R2, BUKAN CDN
            'use_path_style_endpoint' => true,
            'signature_version'       => 'v4',
            'credentials'             => [
                'key'    => getenv('R2_KEY'),
                'secret' => getenv('R2_SECRET'),
            ],
        ]);
    }

    public function index()
    {
        $userModel = new UserModel();
        $user      = $userModel->find(session('user_id'));
        $userId = session('user_id');
        $biodataModel = new BiodataModel();
        $biodata = $biodataModel->where('user_id', $userId)->first();
        

        return view('member/biodata_form', [
            'user'    => $user,
            'biodata' => $biodata ?? [],
            'title'   => 'Profil',
        ]);
    }

    public function save()
    {
        $userId        = session('user_id');
        $biodataModel  = new BiodataModel();
        $userModel     = new UserModel();
        $uploadedPhoto = $this->request->getFile('photo');


        $biodataData = [
            'user_id'        => $userId,
            'nik'            => $this->request->getPost('nik'),
            'gender'         => $this->request->getPost('gender'),
            'birth_place'    => $this->request->getPost('birth_place'),
            'birth_date'     => $this->request->getPost('birth_date'),
            'religion'       => $this->request->getPost('religion'),
            'marital_status' => $this->request->getPost('marital_status'),
            'education'      => $this->request->getPost('education'),
            'occupation'     => $this->request->getPost('occupation'),
            'address'        => $this->request->getPost('address'),
            'phone'          => $this->request->getPost('phone'),
        ];

        // === Upload photo ke R2 ===
        if ($uploadedPhoto && $uploadedPhoto->isValid() && !$uploadedPhoto->hasMoved()) {
            helper('R2_helper');
            try {
                $url = uploadToR2($uploadedPhoto, $userId);
                $biodataData['photo'] = $url;
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            // Tidak ada foto baru, pakai foto lama
            $biodataData['photo'] = $this->request->getPost('old_photo');
        }

        // === Simpan ke database ===
        try {

            $existingBiodata = $biodataModel->where('user_id', $userId)->first();
            if ($existingBiodata) {
                $biodataModel->update($existingBiodata['id'], $biodataData);
                $message = "Biodata berhasil diperbarui.";
            } else {
                $biodataData['id'] = Uuid::uuid4()->toString();
                $biodataModel->insert($biodataData);
                $message = "Biodata berhasil disimpan.";
            }

            $userModel->update($userId, [
                'name'       => $this->request->getPost('fullname'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            log_message('error', 'DB error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

}
