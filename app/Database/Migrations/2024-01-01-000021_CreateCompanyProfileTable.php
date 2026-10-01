<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCompanyProfileTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'key'         => ['type' => 'VARCHAR', 'constraint' => 100],
            'value'       => ['type' => 'LONGTEXT', 'null' => true],
            'type'        => ['type' => 'ENUM', 'constraint' => ['text', 'textarea', 'html', 'image', 'json'], 'default' => 'text'],
            'group'       => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'label'       => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'description' => ['type' => 'TEXT', 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('key');
        $this->forge->createTable('company_profile');
    }

    public function down(): void
    {
        $this->forge->dropTable('company_profile');
    }
}
