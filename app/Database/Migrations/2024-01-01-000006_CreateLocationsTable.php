<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLocationsTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 200],
            'type'        => ['type' => 'ENUM', 'constraint' => ['hotel', 'resort', 'convention_hall', 'training_center', 'other'], 'default' => 'hotel'],
            'address'     => ['type' => 'TEXT', 'null' => true],
            'city'        => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'province'    => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'google_maps' => ['type' => 'TEXT', 'null' => true],
            'phone'       => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'image'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'stars'       => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'description' => ['type' => 'TEXT', 'null' => true],
            'facilities'  => ['type' => 'TEXT', 'null' => true],
            'is_active'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('locations');
    }

    public function down(): void
    {
        $this->forge->dropTable('locations');
    }
}
