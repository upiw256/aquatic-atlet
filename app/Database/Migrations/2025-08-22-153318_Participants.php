<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Participants extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'       => 'UUID',
                'null'       => false,
            ],
            'competition_id' => [
                'type'       => 'UUID',
                'null'       => false,
            ],
            'team_id' => [
                'type'       => 'UUID',
                'null'       => false,
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
        $this->forge->addForeignKey('competition_id', 'competition', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('team_id', 'teams', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('participants');
        $this->db->query("CREATE INDEX idx_participants_competition_id ON participants(competition_id)");
        $this->db->query("CREATE INDEX idx_participants_team_id ON participants(team_id)");
        $this->db->query("CREATE INDEX idx_participants_created_at ON participants(created_at)");
        $this->db->query("CREATE INDEX idx_participants_updated_at ON participants(updated_at)");
    }

    public function down()
    {
        $this->forge->dropTable('participants', true);
        $this->db->query("DROP INDEX IF EXISTS idx_participants_competition_id");
        $this->db->query("DROP INDEX IF EXISTS idx_participants_team_id");
        $this->db->query("DROP INDEX IF EXISTS idx_participants_created_at");
        $this->db->query("DROP INDEX IF EXISTS idx_participants_updated_at");
        $this->forge->dropForeignKey('participants', 'participants_competition_id_foreign');
        $this->forge->dropForeignKey('participants', 'participants_team_id_foreign');
        $this->forge->dropColumn('participants', 'competition_id');
        $this->forge->dropColumn('participants', 'team_id');
        $this->forge->dropColumn('participants', 'created_at');
        $this->forge->dropColumn('participants', 'updated_at');
        $this->forge->dropColumn('participants', 'id');
    }
}
