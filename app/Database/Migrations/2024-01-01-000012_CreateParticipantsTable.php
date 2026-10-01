<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateParticipantsTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'uuid'         => ['type' => 'VARCHAR', 'constraint' => 36],
            'name'         => ['type' => 'VARCHAR', 'constraint' => 200],
            'email'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'phone'        => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'position'     => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'institution'  => ['type' => 'VARCHAR', 'constraint' => 300, 'null' => true],
            'institution_type' => ['type' => 'ENUM', 'constraint' => ['asn', 'bumn', 'bumd', 'swasta', 'universitas', 'yayasan', 'koperasi', 'umkm', 'other'], 'default' => 'other'],
            'address'      => ['type' => 'TEXT', 'null' => true],
            'city'         => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'province'     => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'photo'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'notes'        => ['type' => 'TEXT', 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('uuid');
        $this->forge->createTable('participants');
    }

    public function down(): void
    {
        $this->forge->dropTable('participants');
    }
}
