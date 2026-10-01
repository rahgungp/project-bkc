<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateContactMessagesTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 200],
            'email'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'phone'       => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'institution' => ['type' => 'VARCHAR', 'constraint' => 300, 'null' => true],
            'subject'     => ['type' => 'VARCHAR', 'constraint' => 300],
            'message'     => ['type' => 'TEXT'],
            'is_read'     => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'reply'       => ['type' => 'TEXT', 'null' => true],
            'replied_at'  => ['type' => 'DATETIME', 'null' => true],
            'ip_address'  => ['type' => 'VARCHAR', 'constraint' => 45, 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('contact_messages');
    }

    public function down(): void
    {
        $this->forge->dropTable('contact_messages');
    }
}
