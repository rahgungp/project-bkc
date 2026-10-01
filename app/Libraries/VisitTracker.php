<?php

namespace App\Libraries;

use CodeIgniter\Database\BaseConnection;

class VisitTracker
{
    protected BaseConnection $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function track(string $page = '/'): void
    {
        $ip   = service('request')->getIPAddress();
        $date = date('Y-m-d');

        $this->db->query("
            INSERT INTO page_visits (ip_address, page, visit_date, hits)
            VALUES (?, ?, ?, 1)
            ON DUPLICATE KEY UPDATE hits = hits + 1
        ", [$ip, $page, $date]);
    }

    public function totalUnique(): int
    {
        $row = $this->db->query(
            'SELECT COUNT(DISTINCT ip_address, visit_date) AS total FROM page_visits'
        )->getRowArray();

        return (int) ($row['total'] ?? 0);
    }

    public function totalHits(): int
    {
        $row = $this->db->query(
            'SELECT COALESCE(SUM(hits), 0) AS total FROM page_visits'
        )->getRowArray();

        return (int) ($row['total'] ?? 0);
    }

    public function todayUnique(): int
    {
        $row = $this->db->query(
            'SELECT COUNT(DISTINCT ip_address) AS total FROM page_visits WHERE visit_date = ?',
            [date('Y-m-d')]
        )->getRowArray();

        return (int) ($row['total'] ?? 0);
    }
}
