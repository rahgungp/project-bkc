<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTrainingsTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'uuid'              => ['type' => 'VARCHAR', 'constraint' => 36],
            'category_id'       => ['type' => 'INT', 'unsigned' => true],
            'location_id'       => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'title'             => ['type' => 'VARCHAR', 'constraint' => 300],
            'slug'              => ['type' => 'VARCHAR', 'constraint' => 300],
            'cover'             => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'brochure'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'short_description' => ['type' => 'TEXT', 'null' => true],
            'description'       => ['type' => 'LONGTEXT', 'null' => true],
            'benefits'          => ['type' => 'TEXT', 'null' => true],
            'materials'         => ['type' => 'TEXT', 'null' => true],
            'target_segment'    => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'duration_days'     => ['type' => 'INT', 'default' => 1],
            'duration_hours'    => ['type' => 'INT', 'default' => 8],
            'price'             => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'price_info'        => ['type' => 'TEXT', 'null' => true],
            'max_participants'  => ['type' => 'INT', 'default' => 30],
            'current_participants' => ['type' => 'INT', 'default' => 0],
            'start_date'        => ['type' => 'DATE', 'null' => true],
            'end_date'          => ['type' => 'DATE', 'null' => true],
            'registration_deadline' => ['type' => 'DATE', 'null' => true],
            'status'            => ['type' => 'ENUM', 'constraint' => ['draft', 'published', 'upcoming', 'ongoing', 'completed', 'cancelled'], 'default' => 'draft'],
            'is_featured'       => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'is_online'         => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'online_link'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'certificate_template' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'meta_title'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'meta_description'  => ['type' => 'TEXT', 'null' => true],
            'meta_keywords'     => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'og_image'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'views'             => ['type' => 'INT', 'default' => 0],
            'sort_order'        => ['type' => 'INT', 'default' => 0],
            'created_by'        => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'updated_by'        => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('trainings');
    }

    public function down(): void
    {
        $this->forge->dropTable('trainings');
    }
}
