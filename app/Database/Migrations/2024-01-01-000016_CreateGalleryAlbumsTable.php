<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGalleryAlbumsTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 200],
            'slug'        => ['type' => 'VARCHAR', 'constraint' => 200],
            'cover'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'description' => ['type' => 'TEXT', 'null' => true],
            'type'        => ['type' => 'ENUM', 'constraint' => ['photo', 'video', 'document', 'mixed'], 'default' => 'photo'],
            'category'    => ['type' => 'ENUM', 'constraint' => ['workshop', 'seminar', 'bimtek', 'pkm', 'other'], 'default' => 'other'],
            'event_date'  => ['type' => 'DATE', 'null' => true],
            'sort_order'  => ['type' => 'INT', 'default' => 0],
            'is_active'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('gallery_albums');
    }

    public function down(): void
    {
        $this->forge->dropTable('gallery_albums');
    }
}
