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
        try {
            $this->validate([
                'nik'            => 'permit_empty|max_length[20]',
                'fullname'       => 'required|max_length[255]',
                'gender'         => 'permit_empty|in_list[laki-laki,perempuan]',
                'birth_place'    => 'permit_empty|max_length[100]',
                'birth_date'     => 'permit_empty|valid_date',
                'religion'       => 'permit_empty|max_length[20]',
                'marital_status' => 'permit_empty|in_list[menikah,belum]',
                'education'      => 'permit_empty|max_length[50]',
                'occupation'     => 'permit_empty|max_length[100]',
                'address'        => 'permit_empty',
                'phone'          => 'permit_empty|max_length[20]',
                'photo'          => 'permit_empty|max_length[255]',
            ]);

            $userId = session('user_id');
            $biodataModel = new BiodataModel();
            $userModel = new UserModel();
            $data = [
                'user_id'        => $userId,
                'nik'            => $this->request->getPost('nik'),
                'name'       => $this->request->getPost('fullname'),
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
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move('uploads/photos/', $newName);
                $data['photo'] = 'uploads/photos/' . $newName;
            }

            $existing = $biodataModel->where('user_id', $userId)->first();

            if ($existing) {
                $biodataModel->update($existing['id'], $data);
            } else {
                $data['id'] = Uuid::uuid4()->toString();
                $biodataModel->insert($data);
            }
            $userModel->update($userId, [
                'name' => $this->request->getPost('fullname'),
            ]);
            return redirect()->back()->with('success', 'Biodata berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
}
