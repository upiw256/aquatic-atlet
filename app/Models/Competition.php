<?php

namespace App\Models;

use CodeIgniter\Model;

class Competition extends Model
{
    protected $table            = 'competition';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['name_competition', 'level', 'date', 'location', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = false;

    // Validation
    protected $validationRules      = [
        'name_competition' => 'required',
        'level'            => 'required|in_list[nasional,internasional]',
        'date'             => 'permit_empty|valid_date[Y-m-d]',
        'location'         => 'permit_empty|string|max_length[255]',
    ];
    protected $validationMessages   = [
        'name_competition' => [
            'required' => 'Nama kompetisi harus diisi.',
        ],
        'level'            => [
            'required' => 'Tingkat kompetisi harus diisi.',
            'in_list'  => 'Tingkat kompetisi harus salah satu dari: nasional, internasional.',
        ],
        'date'             => [
            'valid_date' => 'Tanggal harus dalam format YYYY-MM-DD.',
        ],
        'location'         => [
            'string'     => 'Lokasi harus berupa teks.',
            'max_length' => 'Lokasi tidak boleh lebih dari 255 karakter.',
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
