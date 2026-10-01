<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMediaLibraryTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'folder'        => ['type' => 'VARCHAR', 'constraint' => 100, 'default' => 'general'],
            'filename'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'original_name' => ['type' => 'VARCHAR', 'constraint' => 255],
            'file_path'     => ['type' => 'VARCHAR', 'constraint' => 500],
            'file_url'      => ['type' => 'VARCHAR', 'constraint' => 500],
            'mime_type'     => ['type' => 'VARCHAR', 'constraint' => 100],
            'file_size'     => ['type' => 'INT', 'unsigned' => true, 'default' => 0],
            'width'         => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'height'        => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'alt'           => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'uploaded_by'   => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('media_library');
    }

    public function down(): void
    {
        $this->forge->dropTable('media_library');
    }
}
