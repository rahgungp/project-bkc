<?php

namespace Modules\Registration\Models;

use App\Models\BaseModel;

class ParticipantModel extends BaseModel
{
    protected $table = 'participants';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'uuid', 'name', 'email', 'phone', 'position', 'institution',
        'institution_type', 'address', 'city', 'province', 'photo', 'notes'
    ];

    public function findByEmail(string $email): ?array
    {
        return $this->where('email', $email)->where('deleted_at', null)->first();
    }

    public function findOrCreate(array $data): int
    {
        $existing = $this->findByEmail($data['email']);
        if ($existing) {
            // Only update mutable contact fields — never overwrite uuid or email
            $mutable = ['name', 'phone', 'position', 'institution', 'institution_type', 'address', 'city', 'province'];
            $this->update($existing['id'], array_intersect_key($data, array_flip($mutable)));
            return $existing['id'];
        }
        $data['uuid'] = $this->generateUuid();
        $this->insert($data);
        return $this->insertID();
    }
}
