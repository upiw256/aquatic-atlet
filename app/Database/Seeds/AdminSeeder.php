<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Ramsey\Uuid\Uuid;
class AdminSeeder extends Seeder
{
    public function run()
    {
        $uuid = Uuid::uuid4()->toString();

        $data = [
            'id'       => $uuid,
            'name'     => 'Super Admin',
            'email'    => 'bilqimlb@gmail.com',
            'password' => password_hash('5414450', PASSWORD_DEFAULT),
            'role'     => 'admin',
        ];

        $this->db->table('users')->insert($data);
    }
}
