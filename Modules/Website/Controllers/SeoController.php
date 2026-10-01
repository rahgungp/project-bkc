<?php

namespace Modules\Website\Controllers;

use App\Controllers\BaseController;
use Modules\Training\Models\TrainingModel;
use Modules\News\Models\NewsModel;

class SeoController extends BaseController
{
    public function sitemap()
    {
        $trainingModel = new TrainingModel();
        $newsModel = new NewsModel();

        $trainings = $trainingModel->select('slug, updated_at')->where('status', 'published')->where('deleted_at', null)->findAll();
        $news = $newsModel->select('slug, updated_at')->where('status', 'published')->where('deleted_at', null)->findAll();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        $staticPages = ['', 'tentang', 'pelatihan', 'berita', 'galeri', 'testimoni', 'faq', 'kontak', 'profil-pendiri', 'jadwal-pelatihan', 'request-inhouse'];
        foreach ($staticPages as $page) {
            $xml .= '<url><loc>' . base_url($page) . '</loc><changefreq>weekly</changefreq><priority>' . ($page === '' ? '1.0' : '0.8') . '</priority></url>';
        }

        foreach ($trainings as $t) {
            $xml .= '<url><loc>' . htmlspecialchars(base_url('pelatihan/' . $t['slug']), ENT_XML1, 'UTF-8') . '</loc><lastmod>' . date('Y-m-d', strtotime($t['updated_at'])) . '</lastmod><changefreq>weekly</changefreq><priority>0.9</priority></url>';
        }

        foreach ($news as $n) {
            $xml .= '<url><loc>' . htmlspecialchars(base_url('berita/' . $n['slug']), ENT_XML1, 'UTF-8') . '</loc><lastmod>' . date('Y-m-d', strtotime($n['updated_at'])) . '</lastmod><changefreq>daily</changefreq><priority>0.7</priority></url>';
        }

        $xml .= '</urlset>';

        return $this->response->setHeader('Content-Type', 'application/xml')->setBody($xml);
    }

    public function robots()
    {
        $content = "User-agent: *\nAllow: /\nDisallow: /admin/\nSitemap: " . base_url('sitemap.xml');
        return $this->response->setHeader('Content-Type', 'text/plain')->setBody($content);
    }
}
