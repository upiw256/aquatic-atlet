<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterCompetitionsAddLevelLocation extends Migration
{
    public function up()
    {
        $this->forge->addColumn('competitions', [
            'level' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
                'default'    => 'local',
                'comment'    => 'local, kabupaten, provinsi, nasional, internasional'
            ],
            'location' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
                'default'    => '',
                'comment'    => 'Lokasi kompetisi'
            ],
        ]);

        // Index untuk mempercepat query pencarian/filter
        $this->db->query('CREATE INDEX idx_competitions_level ON competitions(level)');
        $this->db->query('CREATE INDEX idx_competitions_location ON competitions(location)');
    }

    public function down()
    {
        // Hapus index dulu
        $this->db->query('DROP INDEX IF EXISTS idx_competitions_level');
        $this->db->query('DROP INDEX IF EXISTS idx_competitions_location');

        // Hapus kolom level & location
        $this->forge->dropColumn('competitions', ['level', 'location']);
    }
}
