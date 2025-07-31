<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateBiodata extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'UUID', 'null' => false],
            'user_id'      => ['type' => 'UUID', 'null' => false],
            'nik'          => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'gender'       => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true], // laki-laki / perempuan
            'birth_place'  => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'birth_date'   => ['type' => 'DATE', 'null' => true],
            'religion'     => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'marital_status' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true], // menikah / belum
            'education'    => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'occupation'   => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'address'      => ['type' => 'TEXT', 'null' => true],
            'phone'        => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'photo'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true], // path foto profil
            'created_at'   => ['type' => 'TIMESTAMP', 'default' => new RawSql('CURRENT_TIMESTAMP')],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('biodata');
    }

    public function down()
    {
        $this->forge->dropTable('biodata');
    }
}
