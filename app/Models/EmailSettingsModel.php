<?php

namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class EmailSettingsModel extends Model
{
    protected $table = 'email_settings';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id', 'from_email', 'from_name', 'smtp_host', 'smtp_user', 'smtp_pass', 'smtp_port', 'smtp_crypto'
    ];
    protected $useTimestamps = true;
    protected $returnType = 'array';
    public $incrementing = false;

    protected function beforeInsert(array $data)
    {
        if (! isset($data['data']['id'])) {
            $data['data']['id'] = Uuid::uuid4()->toString();
        }
        return $data;
    }
}
