<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Ramsey\Uuid\Uuid;
use Faker\Factory;
class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');

        // User random (50 data)
        for ($i = 0; $i < 50; $i++) {
            $roles = ['member', 'admin', 'owner'];
            $data = [
                'id'       => Uuid::uuid4()->toString(),
                'name'     => $faker->name,
                'email'    => $faker->unique()->safeEmail,
                'password' => password_hash('123456', PASSWORD_DEFAULT),
                'role'     => 'member', // Set default role to member
            ];

            $this->db->table('users')->insert($data);
        }
    
    }
}
