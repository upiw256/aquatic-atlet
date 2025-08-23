<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;
use App\Validation\CustomRules;
use PHPUnit\Event\Event;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
        CustomRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------
    /**
     * The list of rules that are used by default.
     *
     * @var array<string, string|array>
     */
    public $event = [
        'start_date' => [
            'rules'  => 'required|valid_date[Y-m-d]',
            'errors' => [
                'required'   => 'Tanggal mulai wajib diisi.',
                'valid_date' => 'Format tanggal mulai salah.',
            ]
        ],
        'end_date' => [
            'rules'  => 'required|valid_date[Y-m-d]|check_end_date[start_date]',
            'errors' => [
                'check_end_date' => 'Tanggal selesai harus setelah tanggal mulai.',
            ]
        ],
        'registration_deadline' => [
            'rules'  => 'required|valid_date[Y-m-d]|check_registration_deadline[start_date]',
            'errors' => [
                'check_registration_deadline' => 'Batas pendaftaran harus sebelum tanggal mulai.',
            ]
        ],
    ];
}
