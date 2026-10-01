<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePageVisitsTable extends Migration
{
    public function up(): void
    {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `page_visits` (
                `id`         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                `ip_address` VARCHAR(45)     NOT NULL,
                `page`       VARCHAR(255)    NOT NULL DEFAULT '/',
                `visit_date` DATE            NOT NULL,
                `hits`       INT UNSIGNED    NOT NULL DEFAULT 1,
                `created_at` TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                UNIQUE KEY `uq_visit` (`ip_address`, `page`, `visit_date`)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
        ");
    }

    public function down(): void
    {
        $this->db->query('DROP TABLE IF EXISTS `page_visits`');
    }
}
