<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterCompetitionsAddDeadline extends Migration
{
    public function up()
    {
        // Tambah kolom registration_deadline
        $this->forge->addColumn('competitions', [
            'registration_deadline' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'end_date', // opsional, biar lebih rapi
            ],
        ]);

        // Tambah index supaya query deadline cepat
        $this->db->query('CREATE INDEX idx_competitions_registration_deadline ON competitions (registration_deadline);');
    }

    public function down()
    {
        // Hapus kolom jika rollback
        $this->forge->dropColumn('competitions', 'registration_deadline');
    }
}
