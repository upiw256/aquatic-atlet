<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use App\Models\BiodataModel;
use App\Models\UserModel;
use Ramsey\Uuid\Uuid;

class ProfileController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $user      = $userModel->find(session('user_id'));
        $userId = session('user_id');
        $biodataModel = new BiodataModel();
        $biodata = $biodataModel->where('user_id', $userId)->first();

        return view('owner/biodata_form', [
            'user'    => $user,
            'biodata' => $biodata ?? []
        ]);
    }

    public function save()
    {
        $userId = session('user_id');
        $biodataModel = new BiodataModel();
        $userModel = new UserModel();

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
            'phone'          => $this->request->getPost('phone')
        ];

        if ($uploadedPhoto && $uploadedPhoto->isValid() && !$uploadedPhoto->hasMoved()) {
            $extension = $uploadedPhoto->getExtension() ?: $uploadedPhoto->guessExtension();
            $photoFileName = 'Profil_' . $userId . '.' . $extension;
            $targetPath = FCPATH . 'uploads/photos/' . $photoFileName;

            // Hapus foto lama jika ekstensi berbeda
            $oldPhoto = $this->request->getPost('old_photo');
            if ($oldPhoto && file_exists(FCPATH . $oldPhoto)) {
                $oldExtension = pathinfo($oldPhoto, PATHINFO_EXTENSION);
                if (strtolower($oldExtension) !== strtolower($extension)) {
                    unlink(FCPATH . $oldPhoto);
                }
            }

            // PROSES RESIZE DULU SEBELUM MOVE
            \Config\Services::image()
                ->withFile($uploadedPhoto) // Gunakan objek file langsung
                ->fit(300, 300, 'center')
                ->save($targetPath);

            // Update path di database
            $biodataData['photo'] = 'uploads/photos/' . $photoFileName;

            // Pindahkan file asli (jika ingin menyimpan versi original)
            // $uploadedPhoto->move(FCPATH . 'uploads/photos/original/', $photoFileName); // Opsional

        } else {
            $biodataData['photo'] = $this->request->getPost('old_photo');
        }

        // Simpan biodata
        $existingBiodata = $biodataModel->where('user_id', $userId)->first();
        if ($existingBiodata) {
            $biodataModel->update($existingBiodata['id'], $biodataData);
            $message = "Biodata berhasil diperbarui.";
        } else {
            $biodataData['id'] = Uuid::uuid4()->toString();
            $biodataModel->insert($biodataData);
            $message = "Biodata berhasil disimpan.";
        }

        // Update nama user
        $userModel->update($userId, ['name' => $this->request->getPost('fullname')]);

        return redirect()->to('/owner/dashboard')->with('success', $message);
    }
}
