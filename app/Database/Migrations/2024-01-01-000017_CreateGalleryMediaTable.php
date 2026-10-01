<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGalleryMediaTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'album_id'    => ['type' => 'INT', 'unsigned' => true],
            'type'        => ['type' => 'ENUM', 'constraint' => ['image', 'video', 'pdf'], 'default' => 'image'],
            'file_path'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'thumbnail'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'title'       => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'description' => ['type' => 'TEXT', 'null' => true],
            'file_size'   => ['type' => 'INT', 'unsigned' => true, 'default' => 0],
            'mime_type'   => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'sort_order'  => ['type' => 'INT', 'default' => 0],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('gallery_media');
    }

    public function down(): void
    {
        $this->forge->dropTable('gallery_media');
    }
}
