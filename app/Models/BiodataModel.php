<?php

namespace App\Models;

use CodeIgniter\Model;

class BiodataModel extends Model
{
    protected $table            = 'biodata';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'id',
        'user_id',
        'nik',
        'gender',
        'birth_place',
        'birth_date',
        'religion',
        'marital_status',
        'education',
        'occupation',
        'address',
        'phone',
        'photo',
        'created_at',
    ];

    protected $useTimestamps = false; // karena hanya created_at

    // Jika ingin validasi otomatis saat insert/update
    protected $validationRules    = [
        'user_id'       => 'required|is_not_unique[users.id]',
        'nik'           => 'permit_empty|max_length[20]',
        'gender'        => 'permit_empty|in_list[laki-laki,perempuan]',
        'birth_place'   => 'permit_empty|max_length[100]',
        'birth_date'    => 'permit_empty|valid_date',
        'religion'      => 'permit_empty|max_length[20]',
        'marital_status' => 'permit_empty|in_list[menikah,belum]',
        'education'     => 'permit_empty|max_length[50]',
        'occupation'    => 'permit_empty|max_length[100]',
        'address'       => 'permit_empty',
        'phone'         => 'permit_empty|max_length[20]',
        'photo'         => 'permit_empty|max_length[255]',
    ];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    function getByUserId($id)
    {
        return $this->where('user_id', $id)->first();
    }
    function getDataFormUser($id)
    {
        return $this->select('
            biodata.*,
            users.name AS user_name,
            users.email AS user_email
        ')
            ->join('users', 'users.id = biodata.user_id')
            ->where('biodata.user_id', $id)
            ->findAll();
    }
}
