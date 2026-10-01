<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFounderProfileTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'name'           => ['type' => 'VARCHAR', 'constraint' => 200],
            'title'          => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'photo'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'bio'            => ['type' => 'LONGTEXT', 'null' => true],
            'education'      => ['type' => 'TEXT', 'null' => true],
            'experience'     => ['type' => 'TEXT', 'null' => true],
            'achievements'   => ['type' => 'TEXT', 'null' => true],
            'email'          => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'linkedin'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'scopus_id'      => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'google_scholar' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'orcid'          => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('founder_profile');
    }

    public function down(): void
    {
        $this->forge->dropTable('founder_profile');
    }
}
