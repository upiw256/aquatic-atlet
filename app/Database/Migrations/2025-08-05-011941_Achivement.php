<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Achivement extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'       => 'UUID',
                'null'       => false,
            ],
            'member_id' => [
                'type'       => 'UUID',
                'null'       => false,
            ],
            'nama_kejuaraan' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'lokasi' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'tingkat' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'tahun' => [
                'type'       => 'INTEGER',
            ],
            'posisi_akhir' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'skor' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('member_id', 'team_members', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('achivements');
    }

    public function down()
    {
        $this->forge->dropTable('achivements');
    }
}
