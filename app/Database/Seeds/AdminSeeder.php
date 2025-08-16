<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Ramsey\Uuid\Uuid;
use Faker\Factory;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');
        $uuid = Uuid::uuid4()->toString();

        // $data = [
        //     'id'       => $uuid,
        //     'name'     => 'Super Admin',
        //     'email'    => 'bilqimlb@gmail.com',
        //     'password' => password_hash('5414450', PASSWORD_DEFAULT),
        //     'role'     => 'admin',
        // ];

        // $this->db->table('users')->insert($data);



            $data = [
                'id'       => Uuid::uuid4()->toString(),
                'name'     => $faker->name,
                'email'    => $faker->unique()->safeEmail,
                'password' => password_hash('123456', PASSWORD_DEFAULT),
                'role'     => 'admin',
                'is_verified' => true,
            ];

            $this->db->table('users')->insert($data);
            
    }
}