<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBannersTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'title'       => ['type' => 'VARCHAR', 'constraint' => 200],
            'subtitle'    => ['type' => 'VARCHAR', 'constraint' => 300, 'null' => true],
            'image'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'link'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'position'    => ['type' => 'ENUM', 'constraint' => ['home', 'training', 'news', 'about', 'other'], 'default' => 'home'],
            'sort_order'  => ['type' => 'INT', 'default' => 0],
            'is_active'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('banners');
    }

    public function down(): void
    {
        $this->forge->dropTable('banners');
    }
}
