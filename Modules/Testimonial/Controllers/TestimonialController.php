<?php

namespace Modules\Testimonial\Controllers;

use App\Controllers\BaseController;
use Modules\Testimonial\Models\TestimonialModel;
use Modules\Profile\Models\CompanyProfileModel;

class TestimonialController extends BaseController
{
    protected TestimonialModel $testimonialModel;
    protected CompanyProfileModel $profileModel;

    public function __construct()
    {
        $this->testimonialModel = new TestimonialModel();
        $this->profileModel = new CompanyProfileModel();
        helper(['url']);
    }

    public function index(): string
    {
        $testimonials = $this->testimonialModel
            ->where('is_approved', 1)
            ->orderBy('is_featured', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $ratings = [
            'total'   => count($testimonials),
            'average' => count($testimonials) > 0
                ? round(array_sum(array_column($testimonials, 'rating')) / count($testimonials), 1)
                : 0,
        ];

        return view('Modules\Testimonial\Views\index', [
            'testimonials' => $testimonials,
            'ratings'      => $ratings,
            'profile'      => $this->profileModel->getAll(),
            'title'        => 'Testimoni Peserta',
        ]);
    }
}
