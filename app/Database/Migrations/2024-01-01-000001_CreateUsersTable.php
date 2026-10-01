<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'uuid'         => ['type' => 'VARCHAR', 'constraint' => 36, 'null' => false],
            'name'         => ['type' => 'VARCHAR', 'constraint' => 100],
            'email'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'password'     => ['type' => 'VARCHAR', 'constraint' => 255],
            'role_id'      => ['type' => 'INT', 'unsigned' => true, 'default' => 1],
            'avatar'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'phone'        => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'is_active'    => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'two_fa_secret'=> ['type' => 'VARCHAR', 'constraint' => 32, 'null' => true],
            'two_fa_enabled'=> ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'last_login'   => ['type' => 'DATETIME', 'null' => true],
            'login_attempts'=> ['type' => 'INT', 'default' => 0],
            'locked_until' => ['type' => 'DATETIME', 'null' => true],
            'reset_token'  => ['type' => 'VARCHAR', 'constraint' => 64, 'null' => true],
            'reset_token_expiry' => ['type' => 'DATETIME', 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('uuid');
        $this->forge->addUniqueKey('email');
        $this->forge->createTable('users');
    }

    public function down(): void
    {
        $this->forge->dropTable('users');
    }
}
