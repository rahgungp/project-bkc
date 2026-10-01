<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePublicationsTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'founder_id'  => ['type' => 'INT', 'unsigned' => true],
            'title'       => ['type' => 'VARCHAR', 'constraint' => 500],
            'type'        => ['type' => 'ENUM', 'constraint' => ['journal', 'book', 'conference', 'thesis', 'other'], 'default' => 'journal'],
            'journal'     => ['type' => 'VARCHAR', 'constraint' => 300, 'null' => true],
            'year'        => ['type' => 'YEAR', 'null' => true],
            'isbn'        => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'issn'        => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'doi'         => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'url'         => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'is_scopus'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'publisher'   => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'abstract'    => ['type' => 'TEXT', 'null' => true],
            'sort_order'  => ['type' => 'INT', 'default' => 0],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('publications');
    }

    public function down(): void
    {
        $this->forge->dropTable('publications');
    }
}
