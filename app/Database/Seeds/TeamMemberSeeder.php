<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class TeamMemberSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');
        $teams = $this->db->table('teams')->select('id')->get()->getResultArray();
        $members = $this->db->table('users')
            ->select('id')
            ->where('role', 'member')
            ->get()
            ->getResultArray();

        $teamMemberData = [];
        $userIdsToUpdate = [];
        shuffle($members);

        $memberIndex = 0;
        foreach ($teams as $team) {
            $membersPerTeam = $faker->numberBetween(3, 6);

            for ($i = 0; $i < $membersPerTeam; $i++) {
                if ($memberIndex >= count($members)) {
                    break 2;
                }

                $memberId = $members[$memberIndex]['id'];

                $teamMemberData[] = [
                    'id' => $faker->uuid(),
                    'team_id' => $team['id'],
                    'member_id' => $memberId,
                    'role' => 'atlet',
                    'created_at' => date('Y-m-d H:i:s'),
                    'status' => 'accepted',
                ];

                $userIdsToUpdate[] = $memberId;
                $memberIndex++;
            }
        }

        // INSERT dan UPDATE di LUAR loop - sekali saja di akhir
        if (!empty($teamMemberData)) {
            $this->db->table('team_members')->insertBatch($teamMemberData);
            echo "Insert " . count($teamMemberData) . " records ke tabel team_member.\n";
        }

        if (!empty($userIdsToUpdate)) {
            $this->db->table('users')
                ->whereIn('id', $userIdsToUpdate)
                ->update(['role' => 'atlet']);
            echo "Update " . count($userIdsToUpdate) . " users role menjadi 'atlet'.\n";
        }
    }
}
