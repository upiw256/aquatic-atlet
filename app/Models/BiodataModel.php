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
    protected $validationRules = [
    'user_id'        => 'required|is_not_unique[users.id]',
    'nik'            => 'required|max_length[20]',
    'gender'         => 'required|in_list[laki-laki,perempuan]',
    'birth_place'    => 'required|max_length[100]',
    'birth_date'     => 'required|valid_date',
    'religion'       => 'required|max_length[20]',
    'marital_status' => 'required|in_list[menikah,belum]',
    'education'      => 'required|max_length[50]',
    'occupation'     => 'required|max_length[100]',
    'address'        => 'required',
    'phone'          => 'required|max_length[20]',
    'photo'          => 'is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]|max_size[photo,2048]'

];

protected $validationMessages = [
    'user_id' => [
        'required'      => 'User ID harus diisi.',
        'is_not_unique' => 'User ID tidak valid.'
    ],
    'nik' => [
        'required'   => 'NIK harus diisi.',
        'max_length' => 'NIK tidak boleh lebih dari 20 karakter.'
    ],
    'fullname' => [
        'required'   => 'Nama lengkap harus diisi.',
        'max_length' => 'Nama lengkap tidak boleh lebih dari 100 karakter.'
    ],
    'gender' => [
        'required'  => 'Jenis kelamin harus diisi.',
        'in_list'   => 'Jenis kelamin harus "laki-laki" atau "perempuan".'
    ],
    'birth_place' => [
        'required'   => 'Tempat lahir harus diisi.',
        'max_length' => 'Tempat lahir tidak boleh lebih dari 100 karakter.'
    ],
    'birth_date' => [
        'required'   => 'Tanggal lahir harus diisi.',
        'valid_date' => 'Tanggal lahir harus dalam format yang benar.'
    ],
    'religion' => [
        'required'   => 'Agama harus diisi.',
        'max_length' => 'Agama tidak boleh lebih dari 20 karakter.'
    ],
    'marital_status' => [
        'required' => 'Status perkawinan harus diisi.',
        'in_list'  => 'Status perkawinan harus "menikah" atau "belum".'
    ],
    'education' => [
        'required'   => 'Pendidikan harus diisi.',
        'max_length' => 'Pendidikan tidak boleh lebih dari 50 karakter.'
    ],
    'occupation' => [
        'required'   => 'Pekerjaan harus diisi.',
        'max_length' => 'Pekerjaan tidak boleh lebih dari 100 karakter.'
    ],
    'address' => [
        'required' => 'Alamat harus diisi.'
    ],
    'phone' => [
        'required'   => 'Nomor telepon harus diisi.',
        'max_length' => 'Nomor telepon tidak boleh lebih dari 20 karakter.'
    ],
    'photo' => [
        'is_image'   => 'File yang diunggah harus berupa gambar.',
        'mime_in'    => 'Format gambar harus JPG, JPEG, atau PNG.',
        'max_size'   => 'Ukuran gambar tidak boleh lebih dari 2MB.'
    ],
];

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
