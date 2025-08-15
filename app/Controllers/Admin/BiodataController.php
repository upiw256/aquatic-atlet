<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BiodataModel;

class BiodataController extends BaseController
{
    public function edit($userId)
    {
        $biodataModel = new BiodataModel();
        $biodata = $biodataModel->where('user_id', $userId)->first();

        return view('admin/biodata_form', [
            'userId' => $userId,
            'biodata' => $biodata ?? []
        ]);
    }

    public function save($userId)
    {
        $biodataModel = new BiodataModel();

        $data = [
            'user_id'    => $userId,
            // 'id'        => $this->request->getPost('id') ?: null, // UUID, bisa kosong saat insert
            'fullname'   => $this->request->getPost('fullname'),
            'birthplace' => $this->request->getPost('birthplace'),
            'birthdate'  => $this->request->getPost('birthdate'),
            'gender'     => $this->request->getPost('gender'),
            'address'    => $this->request->getPost('address'),
            'phone'      => $this->request->getPost('phone'),
        ];

            if (! $biodataModel->validate($data)) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', $biodataModel->errors());
            }


        $existing = $biodataModel->where('user_id', $userId)->first();

        if ($existing) {
            $biodataModel->update($existing['id'], $data);
        } else {
            $biodataModel->insert($data);
        }

        return redirect()->back()->with('success', 'Biodata berhasil disimpan. :)');
    }
}
