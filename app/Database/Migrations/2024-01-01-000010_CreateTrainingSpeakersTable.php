<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTrainingSpeakersTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'training_id' => ['type' => 'INT', 'unsigned' => true],
            'speaker_id'  => ['type' => 'INT', 'unsigned' => true],
            'role'        => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'sort_order'  => ['type' => 'INT', 'default' => 0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('training_speakers');
    }

    public function down(): void
    {
        $this->forge->dropTable('training_speakers');
    }
}
