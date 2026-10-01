<?php

namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model
{
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at';

    protected function logAudit(string $action, int $recordId, array $oldValues = [], array $newValues = []): void
    {
        $this->db->table('audit_logs')->insert([
            'user_id'    => session()->get('admin_id'),
            'action'     => $action,
            'module'     => $this->table,
            'record_id'  => $recordId,
            'old_values' => !empty($oldValues) ? json_encode($oldValues) : null,
            'new_values' => !empty($newValues) ? json_encode($newValues) : null,
            'ip_address' => service('request')->getIPAddress(),
            'user_agent' => service('request')->getUserAgent()->getAgentString(),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function generateUuid(): string
    {
        $data    = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    public function generateSlug(string $title, int $excludeId = 0): string
    {
        helper('url');
        $slug         = url_title(strtolower($title), '-', true);
        $count        = 0;
        $originalSlug = $slug;

        while (true) {
            $builder = $this->where('slug', $slug);
            if ($excludeId > 0) {
                $builder->where('id !=', $excludeId);
            }
            if ($this->useSoftDeletes) {
                $builder->where('deleted_at', null);
            }
            if (!$builder->countAllResults()) {
                break;
            }
            $slug = $originalSlug . '-' . (++$count);
        }

        return $slug;
    }
}
