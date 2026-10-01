<?php

namespace Modules\Website\Controllers;

use App\Controllers\BaseController;
use Modules\Training\Models\TrainingModel;

class SearchController extends BaseController
{
    public function index()
    {
        // Rate limit: 30 requests per minute per IP
        $ip       = $this->request->getIPAddress();
        $cacheKey = 'search_rl_' . md5($ip);
        $cache    = \Config\Services::cache();
        $hits     = (int) ($cache->get($cacheKey) ?? 0);

        if ($hits >= 30) {
            return $this->response->setStatusCode(429)->setJSON(['error' => 'Terlalu banyak permintaan. Coba lagi sebentar.']);
        }

        $cache->save($cacheKey, $hits + 1, 60);

        $query = $this->request->getGet('q') ?? '';
        if (strlen($query) < 2) {
            return $this->response->setJSON([]);
        }

        $trainingModel = new TrainingModel();
        $results = $trainingModel->withAll()
            ->where('trainings.status', 'published')
            ->where('trainings.deleted_at', null)
            ->groupStart()
            ->like('trainings.title', $query)
            ->orLike('trainings.short_description', $query)
            ->groupEnd()
            ->findAll(8);

        $formatted = array_map(function($t) {
            return [
                'id' => $t['id'],
                'title' => $t['title'],
                'category' => $t['category_name'],
                'slug' => $t['slug'],
                'cover' => $t['cover'] ? base_url('assets/uploads/training/' . $t['cover']) : base_url('assets/images/training-placeholder.jpg'),
                'url' => base_url('pelatihan/' . $t['slug']),
                'start_date' => $t['start_date'] ? date('d M Y', strtotime($t['start_date'])) : null,
            ];
        }, $results);

        return $this->response->setJSON($formatted);
    }
}
