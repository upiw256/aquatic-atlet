<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEmailVerificationToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'verification_token' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'role',
            ],
            'is_verified' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
                'after'      => 'verification_token',
            ],
            'email_verified_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'after' => 'is_verified',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'verification_token');
        $this->forge->dropColumn('users', 'is_verified');
        $this->forge->dropColumn('users', 'email_verified_at');
    }
}
