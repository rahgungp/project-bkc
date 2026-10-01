<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSpeakersTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'name'         => ['type' => 'VARCHAR', 'constraint' => 200],
            'title'        => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'speciality'   => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'photo'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'bio'          => ['type' => 'TEXT', 'null' => true],
            'education'    => ['type' => 'TEXT', 'null' => true],
            'experience'   => ['type' => 'TEXT', 'null' => true],
            'linkedin'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'email'        => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'phone'        => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'is_active'    => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('speakers');
    }

    public function down(): void
    {
        $this->forge->dropTable('speakers');
    }
}
