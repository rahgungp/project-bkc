<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNewsTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'               => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'category_id'      => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'author_id'        => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'title'            => ['type' => 'VARCHAR', 'constraint' => 300],
            'slug'             => ['type' => 'VARCHAR', 'constraint' => 300],
            'thumbnail'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'excerpt'          => ['type' => 'TEXT', 'null' => true],
            'content'          => ['type' => 'LONGTEXT', 'null' => true],
            'tags'             => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'status'           => ['type' => 'ENUM', 'constraint' => ['draft', 'published', 'archived'], 'default' => 'draft'],
            'is_featured'      => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'views'            => ['type' => 'INT', 'default' => 0],
            'meta_title'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'meta_description' => ['type' => 'TEXT', 'null' => true],
            'meta_keywords'    => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'og_image'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'published_at'     => ['type' => 'DATETIME', 'null' => true],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('news');
    }

    public function down(): void
    {
        $this->forge->dropTable('news');
    }
}
