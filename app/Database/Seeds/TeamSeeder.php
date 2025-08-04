<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Ramsey\Uuid\Uuid;
use Faker\Factory;

class TeamSeeder extends Seeder
{
    public function run()
    {
                $faker = Factory::create('id_ID');

        // User random (50 data)
        for ($i = 0; $i < 50; $i++) {
            $prefixes = ['Ocean', 'Aqua', 'Fire', 'Thunder', 'Ice', 'Storm', 'Wave', 'Shadow'];
            $suffixes = ['Titans', 'Blasters', 'Squad', 'Warriors', 'Force', 'Vortex', 'Guardians'];

            $name = $prefixes[array_rand($prefixes)] . ' ' . $suffixes[array_rand($suffixes)];
            $data = [
                'id'       => Uuid::uuid4()->toString(),
                'name'     => $name,
                'description'    => $faker->unique()->sentence(50),
                'owner_id' => null,
                'logo'     => '1754240091_5cfdce572a3a6f47783e.png', // Set default role to member
            ];

            $this->db->table('teams')->insert($data);
        }
    }
}
