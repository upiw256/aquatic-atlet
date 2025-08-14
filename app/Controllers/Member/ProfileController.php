<?php

namespace App\Controllers\Member;

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

        return view('member/biodata_form', [
            'user'    => $user,
            'biodata' => $biodata ?? [],
            'title'   => 'Profil',
        ]);
    }

    public function save()
    {
            $userId = session('user_id');

            $biodataModel = new BiodataModel();
            $userModel    = new UserModel();

            // Data tanpa file dulu
            $data = [
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

            // Handle upload foto
            $file = $this->request->getFile('photo');
            // dd($file);
            $fileName = 'Profil_'.$userId . '.' . $file->getExtension();

            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Upload foto baru
                $data['photo'] = 'uploads/photos/' . $fileName;
                if (file_exists(FCPATH . 'uploads/photos/' . $fileName)) {
                    // Hapus foto lama jika ada
                    unlink(FCPATH . 'uploads/photos/' . $fileName);
                }else{

                    $file->move(FCPATH . 'uploads/photos', $fileName);
                }
            } else {
                // Tidak ada upload baru → pakai foto lama
                $data['photo'] = $this->request->getPost('old_photo');
            }
            $existing = $biodataModel->where('user_id', $userId)->first();
            
            if ($existing) {
                if (!$biodataModel->update($existing['id'], $data)) {
                    return redirect()->back()
                    ->withInput()
                    ->with('error', $biodataModel->errors());
                }
                
                $hasil = "Biodata berhasil diperbarui.";
            } else {
                $data['id'] = Uuid::uuid4()->toString();
                if (!$biodataModel->insert($data)) {
                    return redirect()->back()
                    ->withInput()
                    ->with('error', $biodataModel->errors());
                }
                $hasil = "Biodata berhasil disimpan.";
            }

            // Update nama di tabel user
            $userModel->update($userId, [
                'name' => $this->request->getPost('fullname'),
            ]);

            return redirect()->back()
                ->with('success', $hasil);
    }
}
