<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\EmailSettingsModel;
use CodeIgniter\HTTP\ResponseInterface;
use Ramsey\Uuid\Uuid;

class SettingEmailController extends BaseController
{
    public function index()
    {
        $model = new EmailSettingsModel();
        $settings = $model->first();

        return view('admin/email_settings', [
            'settings' => $settings
        ]);
    }
    public function save()
    {
        $model = new EmailSettingsModel();

        $data = [
            'id'          => Uuid::uuid4()->toString(),
            'from_email'  => $this->request->getPost('from_email'),
            'from_name'   => $this->request->getPost('from_name'),
            'smtp_host'   => $this->request->getPost('smtp_host'),
            'smtp_user'   => $this->request->getPost('smtp_user'),
            'smtp_pass'   => $this->request->getPost('smtp_pass'),
            'smtp_port'   => $this->request->getPost('smtp_port'),
            'smtp_crypto' => $this->request->getPost('smtp_crypto'),
        ];

        $existing = $model->first();

        if ($existing) {
            // Update berdasarkan UUID
            $model->update($existing['id'], $data);
        } else {
            // Insert baru (UUID otomatis dari beforeInsert di model)
            $model->insert($data);
        }

        return redirect()->to('/email-settings')->with('success', 'Pengaturan email berhasil disimpan.');
    }
}
