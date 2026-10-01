<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRegistrationsTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'uuid'           => ['type' => 'VARCHAR', 'constraint' => 36],
            'registration_code' => ['type' => 'VARCHAR', 'constraint' => 50],
            'training_id'    => ['type' => 'INT', 'unsigned' => true],
            'participant_id' => ['type' => 'INT', 'unsigned' => true],
            'status'         => ['type' => 'ENUM', 'constraint' => ['pending', 'confirmed', 'rejected', 'paid', 'completed', 'cancelled'], 'default' => 'pending'],
            'payment_method' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'payment_proof'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'payment_date'   => ['type' => 'DATETIME', 'null' => true],
            'amount'         => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'special_request'=> ['type' => 'TEXT', 'null' => true],
            'certificate_path' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'certificate_issued' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'notes'          => ['type' => 'TEXT', 'null' => true],
            'confirmed_by'   => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'confirmed_at'   => ['type' => 'DATETIME', 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('uuid');
        $this->forge->addUniqueKey('registration_code');
        $this->forge->createTable('registrations');
    }

    public function down(): void
    {
        $this->forge->dropTable('registrations');
    }
}
