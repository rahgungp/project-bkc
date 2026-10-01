<?php

namespace Modules\FAQ\Controllers;

use App\Controllers\BaseController;
use Modules\FAQ\Models\FaqModel;
use Modules\Profile\Models\CompanyProfileModel;

class FaqController extends BaseController
{
    protected FaqModel $faqModel;
    protected CompanyProfileModel $profileModel;

    public function __construct()
    {
        $this->faqModel = new FaqModel();
        $this->profileModel = new CompanyProfileModel();
        helper(['url', 'form']);
    }

    public function index(): string
    {
        $faqs = $this->faqModel->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->orderBy('created_at', 'ASC')
            ->findAll();

        $grouped = [];
        foreach ($faqs as $faq) {
            $category = $faq['category'] ?: 'Umum';
            $grouped[$category][] = $faq;
        }

        return view('Modules\FAQ\Views\index', [
            'faqs'    => $faqs,
            'grouped' => $grouped,
            'profile' => $this->profileModel->getAll(),
            'title'   => 'FAQ - Pertanyaan yang Sering Diajukan',
        ]);
    }
}
