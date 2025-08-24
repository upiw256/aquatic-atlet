<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class BiodataSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');
        $userIds = $this->db->table('users')
            ->select('id')
            ->get()
            ->getResultArray();
        if (empty($userIds)) {
            echo "Tidak ada user dengan role 'member'. Pastikan ada user dengan role member terlebih dahulu.\n";
            return;
        }
        $biodataData = [];
        foreach ($userIds as $user) {
            $gender = $faker->randomElement(['Laki-laki', 'Perempuan']);

            $biodataData[] = [
                'id' => $faker->uuid(),
                'user_id' => $user['id'],
                'nik' => $faker->numerify('################'), // 16 digit NIK
                'gender' => $gender,
                'birth_place' => $faker->city(),
                'birth_date' => $faker->date('Y-m-d', '2000-01-01'),
                'religion' => $faker->randomElement([
                    'Islam',
                    'Kristen',
                    'Katolik',
                    'Hindu',
                    'Buddha',
                    'Konghucu'
                ]),
                'marital_status' => $faker->randomElement([
                    'Belum Menikah',
                    'Menikah',
                    'Cerai Hidup',
                    'Cerai Mati'
                ]),
                'education' => $faker->randomElement([
                    'SD',
                    'SMP',
                    'SMA/SMK',
                    'D3',
                    'S1',
                    'S2',
                    'S3'
                ]),
                'occupation' => $faker->randomElement([
                    'Karyawan Swasta',
                    'PNS',
                    'Wiraswasta',
                    'Mahasiswa',
                    'Ibu Rumah Tangga',
                    'Pensiunan',
                    'Buruh',
                    'Petani',
                    'Pedagang',
                    'Guru',
                    'Dokter',
                    'Perawat',
                    'Polisi',
                    'TNI'
                ]),
                'address' => $faker->address(),
                'phone' => $faker->phoneNumber(),
                'photo' => $faker->randomElement([
                    'uploads/photos/Profil_232e22b0-6334-483c-a71e-066649f4338f.jpg',
                    'uploads/photos/1754357633_461a14785ed72ae0bb1b.png',
                    'uploads/photos/1754289054_d5349b6983769f63d1de.png',
                ]),
                'created_at' => date('Y-m-d H:i:s'),
            ];
        }
        $this->db->table('biodata')->insertBatch($biodataData);
    }
}
