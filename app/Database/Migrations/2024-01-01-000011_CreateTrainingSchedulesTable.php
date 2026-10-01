<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTrainingSchedulesTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'training_id' => ['type' => 'INT', 'unsigned' => true],
            'day_number'  => ['type' => 'INT', 'default' => 1],
            'date'        => ['type' => 'DATE', 'null' => true],
            'start_time'  => ['type' => 'TIME', 'null' => true],
            'end_time'    => ['type' => 'TIME', 'null' => true],
            'topic'       => ['type' => 'VARCHAR', 'constraint' => 300, 'null' => true],
            'speaker_id'  => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'description' => ['type' => 'TEXT', 'null' => true],
            'sort_order'  => ['type' => 'INT', 'default' => 0],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('training_schedules');
    }

    public function down(): void
    {
        $this->forge->dropTable('training_schedules');
    }
}
