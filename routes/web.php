<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\TranslationController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\ContactController;
use App\Models\Service;
use App\Models\Blog;
use App\Models\Slider;
use App\Models\Setting;
use App\Models\Section;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Public Routes
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'sliders' => Slider::with('translations')->active()->ordered()->get(),
        'services' => Service::with('translations')->active()->ordered()->get(),
        'blogs' => Blog::with('translations')->published()->latest()->take(3)->get(),
        'aboutUs' => Section::getData('about_us'),
        'stats' => Section::getData('stats'),
        'workingHours' => Section::getData('working_hours'),
        'contactInfo' => Section::with('translations')->where('key', 'contact')->first()?->data,
        'socialLinks' => [
            'facebook' => Setting::get('facebook_url', ''),
            'instagram' => Setting::get('instagram_url', ''),
        ],
        'seo' => [
            'title' => Setting::where('key', 'meta_title')->first()?->value ?? 'ПЗУ Медика',
            'description' => Setting::where('key', 'meta_description')->first()?->value ?? '',
            'keywords' => Setting::where('key', 'meta_keywords')->first()?->value ?? '',
            'og_image' => Setting::where('key', 'og_image')->first()?->value ?? '/images/logo.png',
        ],
    ]);
});

Route::get('/services', function () {
    return Inertia::render('Services', [
        'services' => Service::with('translations')->active()->ordered()->get(),
        'socialLinks' => [
            'facebook' => Setting::get('facebook_url', ''),
            'instagram' => Setting::get('instagram_url', ''),
        ],
    ]);
});

Route::get('/news', function () {
    return Inertia::render('News/Index', [
        'blogs' => Blog::with('translations')->published()->latest()->get(),
        'socialLinks' => [
            'facebook' => Setting::get('facebook_url', ''),
            'instagram' => Setting::get('instagram_url', ''),
        ],
    ]);
});

Route::get('/news/{slug}', function ($slug) {
    $blog = Blog::with('translations')->where('slug', $slug)->firstOrFail();
    $blog->incrementViews();
    return Inertia::render('News/Show', [
        'blog' => $blog,
        'relatedBlogs' => Blog::with('translations')->published()->where('id', '!=', $blog->id)->take(2)->get(),
        'socialLinks' => [
            'facebook' => Setting::get('facebook_url', ''),
            'instagram' => Setting::get('instagram_url', ''),
        ],
    ]);
});

Route::get('/contact', function () {
    return Inertia::render('Contact', [
        'workingHours' => Section::getData('working_hours'),
        'contactSubjects' => Setting::get('contact_subjects', 'Закажување преглед,Општи информации,Поплака,Друго'),
        'socialLinks' => [
            'facebook' => Setting::get('facebook_url', ''),
            'instagram' => Setting::get('instagram_url', ''),
        ],
    ]);
});

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Admin Routes
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('services', ServiceController::class);
    Route::resource('blogs', BlogController::class);
    Route::resource('sliders', SliderController::class);
    
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    
    Route::get('/sections', [SectionController::class, 'index'])->name('sections.index');
    Route::get('/sections/{section}/edit', [SectionController::class, 'edit'])->name('sections.edit');
    Route::put('/sections/{section}', [SectionController::class, 'update'])->name('sections.update');
    
    Route::get('/translations', [TranslationController::class, 'index'])->name('translations.index');
    Route::post('/translations', [TranslationController::class, 'store'])->name('translations.store');
    Route::post('/translations/bulk', [TranslationController::class, 'bulkStore'])->name('translations.bulk');
    
    Route::get('/contacts', [AdminContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{contact}', [AdminContactController::class, 'show'])->name('contacts.show');
    Route::delete('/contacts/{contact}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
