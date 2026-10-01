<?php

namespace Modules\Profile\Models;

use App\Models\BaseModel;

class CompanyProfileModel extends BaseModel
{
    protected $table = 'company_profile';
    protected $primaryKey = 'id';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['key', 'value', 'type', 'group', 'label', 'description'];

    /** @var array<string, mixed> */
    protected static array $cache = [];

    public function getSetting(string $key, mixed $default = null): mixed
    {
        if (isset(self::$cache[$key])) {
            return self::$cache[$key];
        }
        $row = $this->where('key', $key)->first();
        if (!$row) {
            return $default;
        }
        $value = $row['value'];
        if ($row['type'] === 'json') {
            $value = json_decode($value, true);
        }
        self::$cache[$key] = $value;
        return $value;
    }

    public function setValue(string $key, mixed $value): bool
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }
        $existing = $this->where('key', $key)->first();
        if ($existing) {
            return (bool) $this->update($existing['id'], ['value' => $value]);
        }
        return (bool) $this->insert(['key' => $key, 'value' => $value]);
    }

    public function getGroup(string $group): array
    {
        $rows = $this->where('group', $group)->findAll();
        $result = [];
        foreach ($rows as $row) {
            $value = $row['value'];
            if ($row['type'] === 'json') {
                $value = json_decode($value, true);
            }
            self::$cache[$row['key']] = $value;
            $result[$row['key']] = $value;
        }
        return $result;
    }

    public function getAll(): array
    {
        $rows = $this->findAll();
        $result = [];
        foreach ($rows as $row) {
            $value = $row['value'];
            if ($row['type'] === 'json') {
                $value = json_decode($value, true);
            }
            self::$cache[$row['key']] = $value;
            $result[$row['key']] = $value;
        }
        return $result;
    }

    public function updateSettings(array $data): void
    {
        foreach ($data as $key => $value) {
            $this->setValue($key, $value);
        }
        self::$cache = [];
    }
}
