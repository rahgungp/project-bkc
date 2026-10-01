<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInhouseRequestsTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'                 => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'name'               => ['type' => 'VARCHAR', 'constraint' => 200],
            'email'              => ['type' => 'VARCHAR', 'constraint' => 100],
            'phone'              => ['type' => 'VARCHAR', 'constraint' => 20],
            'institution'        => ['type' => 'VARCHAR', 'constraint' => 300],
            'position'           => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'topic'              => ['type' => 'VARCHAR', 'constraint' => 300],
            'preferred_date'     => ['type' => 'DATE', 'null' => true],
            'participants_count' => ['type' => 'INT', 'default' => 1],
            'location_pref'      => ['type' => 'VARCHAR', 'constraint' => 300, 'null' => true],
            'budget'             => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'message'            => ['type' => 'TEXT', 'null' => true],
            'status'             => ['type' => 'ENUM', 'constraint' => ['pending', 'contacted', 'confirmed', 'rejected'], 'default' => 'pending'],
            'notes'              => ['type' => 'TEXT', 'null' => true],
            'created_at'         => ['type' => 'DATETIME', 'null' => true],
            'updated_at'         => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('inhouse_requests');
    }

    public function down(): void
    {
        $this->forge->dropTable('inhouse_requests');
    }
}
