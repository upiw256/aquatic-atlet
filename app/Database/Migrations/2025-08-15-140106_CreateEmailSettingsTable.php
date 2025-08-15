<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmailSettingsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => [
                'type'       => 'UUID',
                'null'       => false,
            ],
            'from_email'   => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'from_name'    => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'smtp_host'    => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'smtp_user'    => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'smtp_pass'    => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'smtp_port'    => [
                'type'       => 'INT',
                'constraint' => 5,
                'default'    => 587,
            ],
            'smtp_crypto'  => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'default'    => 'tls',
            ],
            'created_at'   => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at'   => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('email_settings');
    }

    public function down()
    {
        $this->forge->dropTable('email_settings');
    }
}
