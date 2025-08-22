<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Competition extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'       => 'UUID',
                'null'       => false,
            ],
            'name_competition' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'level' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'nasional',
            ],
            'date' => [
                'type'       => 'DATE',
                'null'       => true,
            ],
            'location' => [
                'type'       => 'TEXT',
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
        $this->forge->createTable('competition');
        $this->db->query("CREATE INDEX idx_competition_name ON competition(name_competition)");
        $this->db->query("CREATE INDEX idx_competition_level ON competition(level)");
        $this->db->query("CREATE INDEX idx_competition_date ON competition(date)");
        $this->db->query("CREATE INDEX idx_competition_location ON competition(location)");
    }

    public function down()
    {
        $this->forge->dropTable('competition');
        $this->db->query("DROP INDEX IF EXISTS idx_competition_name");
        $this->db->query("DROP INDEX IF EXISTS idx_competition_level");
        $this->db->query("DROP INDEX IF EXISTS idx_competition_date");
        $this->db->query("DROP INDEX IF EXISTS idx_competition_location");
    }
}
