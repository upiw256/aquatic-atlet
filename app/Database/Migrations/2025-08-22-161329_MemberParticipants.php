<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MemberParticipants extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'UUID',
                'null' => false,
            ],
            'participant_id' => [
                'type' => 'UUID',
                'null' => false,
            ],
            'member_id' => [
                'type' => 'UUID',
                'null' => false,
            ],
            'goal' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('participant_id', 'participants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('member_id', 'team_members', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('member_participants');

        // Tambahkan index manual
        $this->db->query("CREATE INDEX idx_member_participants_participant_id ON member_participants(participant_id)");
        $this->db->query("CREATE INDEX idx_member_participants_member_id ON member_participants(member_id)");
        $this->db->query("CREATE INDEX idx_member_participants_created_at ON member_participants(created_at)");
        $this->db->query("CREATE INDEX idx_member_participants_updated_at ON member_participants(updated_at)");
    }

    public function down()
    {
        // Drop foreign keys dulu
        $this->forge->dropForeignKey('member_participants', 'member_participants_participant_id_foreign');
        $this->forge->dropForeignKey('member_participants', 'member_participants_member_id_foreign');

        // Drop index
        $this->db->query("DROP INDEX IF EXISTS idx_member_participants_participant_id");
        $this->db->query("DROP INDEX IF EXISTS idx_member_participants_member_id");
        $this->db->query("DROP INDEX IF EXISTS idx_member_participants_created_at");
        $this->db->query("DROP INDEX IF EXISTS idx_member_participants_updated_at");

        // Terakhir drop tabel
        $this->forge->dropTable('member_participants', true);
    }
}
