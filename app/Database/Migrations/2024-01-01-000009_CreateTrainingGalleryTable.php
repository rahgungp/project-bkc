<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTrainingGalleryTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'training_id' => ['type' => 'INT', 'unsigned' => true],
            'image'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'caption'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'sort_order'  => ['type' => 'INT', 'default' => 0],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('training_gallery');
    }

    public function down(): void
    {
        $this->forge->dropTable('training_gallery');
    }
}
