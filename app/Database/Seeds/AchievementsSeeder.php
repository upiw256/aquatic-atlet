<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class AchievementsSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');

        // Ambil id dari tabel team_members (bukan member_id) karena FK mengarah ke team_members.id
        $athletes = $this->db->table('team_members')
            ->select('id as member_id') // Ambil 'id' dari team_members, alias jadi member_id
            ->where('role', 'atlet')
            ->get()
            ->getResultArray();

        // Validasi data
        if (empty($athletes)) {
            echo "Tidak ada atlet di tabel team_members. Jalankan TeamMemberSeeder terlebih dahulu.\n";
            return;
        }

        // Data kejuaraan dan lokasi yang realistis
        $competitions = [
            'Kejuaraan Nasional Sepak Bola',
            'Liga Sepak Bola Indonesia',
            'Piala Indonesia',
            'Kejuaraan Daerah Jawa Barat',
            'Tournament Antar Klub',
            'Piala Persahabatan',
            'Kejuaraan Sepak Bola Remaja',
            'Liga Amateur Indonesia',
            'Kejuaraan Sepak Bola Pelajar',
            'Tournament Invitation Cup'
        ];

        $locations = [
            'Jakarta',
            'Bandung',
            'Surabaya',
            'Yogyakarta',
            'Semarang',
            'Medan',
            'Makassar',
            'Palembang',
            'Denpasar',
            'Malang'
        ];

        $levels = [
            'Nasional',
            'Provinsi',
            'Kabupaten/Kota',
            'Regional',
            'Antar Klub'
        ];

        $positions = [
            'Juara 1',
            'Juara 2',
            'Juara 3',
            'Juara Harapan 1',
            'Juara Harapan 2',
            'Semifinalis',
            'Top Scorer',
            'Best Player',
            'Fair Play Award'
        ];

        $achievementsData = [];

        // Buat 2-4 achievement untuk setiap atlet
        foreach ($athletes as $athlete) {
            $numAchievements = $faker->numberBetween(2, 4);

            for ($i = 0; $i < $numAchievements; $i++) {
                $year = $faker->numberBetween(2020, 2024);

                $achievementsData[] = [
                    'id' => $faker->uuid(),
                    'member_id' => $athlete['member_id'],
                    'nama_kejuaraan' => $faker->randomElement($competitions),
                    'lokasi' => $faker->randomElement($locations),
                    'tingkat' => $faker->randomElement($levels),
                    'tahun' => $year,
                    'posisi_akhir' => $faker->randomElement($positions),
                    'skor' => (string) $faker->numberBetween(0, 25), // Cast ke string karena skor adalah VARCHAR
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
            }
        }

        // Shuffle untuk variasi data
        shuffle($achievementsData);

        // Insert data ke tabel achivements
        if (!empty($achievementsData)) {
            // Batch insert dengan chunk untuk menghindari memory limit
            $chunks = array_chunk($achievementsData, 100);
            $totalInserted = 0;

            foreach ($chunks as $chunk) {
                $this->db->table('achivements')->insertBatch($chunk);
                $totalInserted += count($chunk);
            }

            echo "AchievementsSeeder berhasil dijalankan untuk {$totalInserted} records.\n";
            echo "Total atlet yang punya prestasi: " . count($athletes) . "\n";
            echo "Rata-rata prestasi per atlet: " . round($totalInserted / count($athletes), 1) . "\n";
        } else {
            echo "Tidak ada data achievements yang dibuat.\n";
        }
    }
}
