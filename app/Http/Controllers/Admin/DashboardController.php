<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Service;
use App\Models\Slider;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'services' => Service::count(),
                'blogs' => Blog::count(),
                'published_blogs' => Blog::published()->count(),
                'sliders' => Slider::active()->count(),
            ],
            'recent_blogs' => Blog::latest()->take(5)->get(),
        ]);
    }
}
