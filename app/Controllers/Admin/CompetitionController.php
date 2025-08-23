<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Competition;

class CompetitionController extends BaseController
{
    protected $competitionModel;

    public function __construct()
    {
        $this->competitionModel = new Competition();
    }

    public function index()
    {
        $competitions = $this->competitionModel->findAll();

        return view('admin/competitions/index', [
            'competitions' => $competitions,
        ]);
    }

    public function create()
    {
        return view('admin/competitions/create');
    }

    public function store()
    {
        $data = [
            'name'                  => $this->request->getPost('name'),
            'description'           => $this->request->getPost('description'),
            'level'                 => $this->request->getPost('level'),
            'start_date'            => $this->request->getPost('start_date'),
            'end_date'              => $this->request->getPost('end_date'),
            'registration_deadline' => $this->request->getPost('registration_deadline'),
            'location'              => $this->request->getPost('location'),
        ];
        // dd($data);

        if ($this->competitionModel->insert($data)) {
            return redirect()->to(site_url('admin/competitions'))
                ->with('success', 'Kompetisi berhasil ditambahkan.');
        }
        $errors = $this->competitionModel->errors();
        // kalau gagal validasi
        return redirect()->back()
            ->withInput()
            ->with('error', implode('<br>', $errors));
    }


    public function edit($id)
    {
        $competition = $this->competitionModel->find($id);

        if (!$competition) {
            return redirect()->to(site_url('admin/competitions'))
                ->with('error', 'Kompetisi tidak ditemukan.');
        }

        return view('admin/competitions/edit', [
            'competition' => $competition,
        ]);
    }

    public function update($id)
    {
        $data = [
            'name_competition'      => $this->request->getPost('name_competition'),
            'level'                 => $this->request->getPost('level'),
            'date'                  => $this->request->getPost('date'),
            'location'              => $this->request->getPost('location'),
            'registration_deadline' => $this->request->getPost('registration_deadline'),
        ];

        if ($this->competitionModel->update($id, $data)) {
            return redirect()->to(site_url('admin/competitions'))
                ->with('success', 'Kompetisi berhasil diperbarui.');
        }

        return redirect()->back()->withInput()
            ->with('errors', $this->competitionModel->errors());
    }

    public function delete($id)
    {
        if ($this->competitionModel->delete($id)) {
            return redirect()->to(site_url('admin/competitions'))
                ->with('success', 'Kompetisi berhasil dihapus.');
        }

        return redirect()->to(site_url('admin/competitions'))
            ->with('error', 'Gagal menghapus kompetisi.');
    }
}
