<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterAchivementsDropColumns extends Migration
{
    public function up()
    {
        // Hapus kolom yang tidak diperlukan
        $this->forge->dropColumn('achivements', ['nama_kejuaraan', 'lokasi', 'tingkat', 'tahun','member_id']);
        // Hapus foreign key yang terkait dengan kolom yang dihapus
        $this->forge->dropForeignKey('achivements', 'achivements_member_id_foreign');
        // Tambahkan kolom baru untuk menyimpan ID kompetisi
        $this->forge->addColumn('achivements', [
            'competition_id' => [
                'type'       => 'UUID',
                'null'       => false,
            ],
        ]);
        // Tambahkan foreign key untuk menghubungkan dengan tabel competition
        $this->forge->addForeignKey('competition_id', 'competition', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        // Kembalikan kolom yang dihapus jika rollback
        $this->forge->addColumn('achivements', [
            'nama_kejuaraan' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'lokasi' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'tingkat' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'tahun' => [
                'type'       => 'INTEGER',
                'null'       => false,
            ],
        ]);
        // Hapus foreign key jika rollback
        $this->forge->dropForeignKey('achivements', 'competition_id');
        // Hapus kolom baru jika rollback
        $this->forge->dropColumn('achivements', [
            'competition_id',
        ]);
    }
}
