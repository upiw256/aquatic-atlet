<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusToTeamMembers extends Migration
{
    public function up()
    {
        $fields = [
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'pending',
                'after'      => 'role' // letakkan setelah kolom 'role'
            ],
        ];

        $this->forge->addColumn('team_members', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('team_members', 'status');
    }
}
