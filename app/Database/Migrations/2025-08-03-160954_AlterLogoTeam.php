<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterLogoTeam extends Migration
{
    public function up()
    {
        $this->forge->addColumn('teams', [
            'logo' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'name' // Letakkan setelah kolom 'name', sesuaikan jika kolom berbeda
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('teams', 'logo');
    }
}
