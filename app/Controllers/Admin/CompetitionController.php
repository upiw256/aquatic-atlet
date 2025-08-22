<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Competition;
use Ramsey\Uuid\Uuid;

class CompetitionController extends BaseController
{
    public function index()
    {
        $competitionsModel = new Competition();
        $competitions = $competitionsModel->findAll();
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
        $competitionsModel = new Competition();
        $data = [
            'id'=> Uuid::uuid4()->toString(),
            'name_competition' => $this->request->getPost('name_competition'),
            'level' => $this->request->getPost('level'),
            'date' => $this->request->getPost('date'),
            'location' => $this->request->getPost('location'),
        ];
        
        if ($competitionsModel->insert($data)) {
            return redirect()->to(site_url('admin/competitions'))->with('success', 'Kompetisi berhasil ditambahkan.');
        } else {
            return redirect()->back()->withInput()->with('errors', $competitionsModel->errors());
        }
    }
}
