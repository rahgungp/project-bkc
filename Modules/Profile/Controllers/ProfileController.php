<?php

namespace Modules\Profile\Controllers;

use App\Controllers\BaseController;
use App\Libraries\VisitTracker;
use Modules\Profile\Models\CompanyProfileModel;
use Modules\Profile\Models\FounderProfileModel;
use Modules\Profile\Models\PublicationModel;

class ProfileController extends BaseController
{
    /**
     * Frontend About page: company history, vision/mission, stats, and founder snippet.
     */
    public function about()
    {
        helper(['url']);

        $profileModel = new CompanyProfileModel();
        $founderModel = new FounderProfileModel();

        $profile = $profileModel->getAll();
        $founder = $founderModel->getMain();

        $tracker = new VisitTracker();
        $tracker->track('tentang');

        return view('Modules\Profile\Views\about', [
            'meta_title'       => 'Tentang Kami - CV. Bagus Kencana Cakrada',
            'meta_description' => $profile['meta_description'] ?? 'Tentang CV. Bagus Kencana Cakrada, mitra terpercaya pengembangan SDM melalui Bimtek, Workshop, Seminar, dan Pelatihan bidang EMBA di Bali.',
            'profile'          => $profile,
            'founder'          => $founder,
            'totalVisitors'    => $tracker->totalUnique(),
            'todayVisitors'    => $tracker->todayUnique(),
        ]);
    }

    /**
     * Frontend Founder detail page.
     */
    public function founder()
    {
        helper(['url']);

        $founderModel     = new FounderProfileModel();
        $publicationModel = new PublicationModel();

        $founder = $founderModel->getMain();

        if (!$founder) {
            return redirect()->to(base_url('tentang'));
        }

        $publications = $publicationModel->getByFounder($founder['id']);

        $profileModel = new CompanyProfileModel();
        $profile      = $profileModel->getAll();

        return view('Modules\Profile\Views\founder', [
            'meta_title'       => ($founder['name'] ?? 'Pendiri') . ' - CV. Bagus Kencana Cakrada',
            'meta_description' => 'Profil lengkap ' . ($founder['name'] ?? '') . ', pendiri CV. Bagus Kencana Cakrada.',
            'founder'          => $founder,
            'publications'     => $publications,
            'profile'          => $profile,
        ]);
    }

    /**
     * Frontend Publications listing page.
     */
    public function publications()
    {
        helper(['url']);

        $founderModel     = new FounderProfileModel();
        $publicationModel = new PublicationModel();
        $profileModel     = new CompanyProfileModel();

        $founder      = $founderModel->getMain();
        $publications = $founder ? $publicationModel->getByFounder($founder['id']) : [];
        $profile      = $profileModel->getAll();

        return view('Modules\Profile\Views\publications', [
            'meta_title'       => 'Publikasi - CV. Bagus Kencana Cakrada',
            'meta_description' => 'Karya tulis ilmiah, jurnal, buku, dan artikel dari pendiri CV. Bagus Kencana Cakrada.',
            'publications'     => $publications,
            'founder'          => $founder,
            'profile'          => $profile,
        ]);
    }
}
