<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTestimonialsTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'training_id' => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 200],
            'position'    => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'institution' => ['type' => 'VARCHAR', 'constraint' => 300, 'null' => true],
            'photo'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'rating'      => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 5],
            'comment'     => ['type' => 'TEXT'],
            'is_approved' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'is_featured' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'sort_order'  => ['type' => 'INT', 'default' => 0],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('testimonials');
    }

    public function down(): void
    {
        $this->forge->dropTable('testimonials');
    }
}
