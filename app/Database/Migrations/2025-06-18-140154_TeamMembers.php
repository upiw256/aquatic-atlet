<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class TeamMembers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'UUID', 'null' => false],
            'team_id'    => ['type' => 'UUID', 'null' => false],     // FK ke teams
            'member_id'  => ['type' => 'UUID', 'null' => false],     // FK ke users
            'role'       => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'atlet'],
            'created_at' => ['type' => 'TIMESTAMP', 'default' => new RawSql('CURRENT_TIMESTAMP')],
        ]);

        $this->forge->addKey('id', true); // Primary key

        $this->forge->addForeignKey('team_id', 'teams', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('member_id', 'users', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('team_members');
    }

    public function down()
    {
        $this->forge->dropTable('team_members');
    }
}
