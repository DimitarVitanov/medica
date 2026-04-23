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
use App\Http\Controllers\Admin\LabAnalysisController;
use App\Http\Controllers\Admin\DailyDoseController;
use App\Models\DailyDose;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\Admin\SubscriberController as AdminSubscriberController;
use App\Models\Service;
use App\Models\Blog;
use App\Models\Slider;
use App\Models\Setting;
use App\Models\Section;
use App\Models\LabAnalysisCategory;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Sitemap
Route::get('/sitemap.xml', [SitemapController::class, 'index']);

// Public Routes
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'sliders' => Slider::with('translations')->active()->ordered()->get(),
        'services' => Service::with('translations')->active()->ordered()->get(),
        'blogs' => Blog::with('translations')->orderBy('id','desc')->take(3)->get(),
        'dailyDoses' => DailyDose::with('translations')->published()->latest()->take(3)->get(),
        'aboutUs' => Section::with('translations')->where('key', 'about_us')->first(),
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
        'workingHours' => Section::getData('working_hours'),
        'socialLinks' => [
            'facebook' => Setting::get('facebook_url', ''),
            'instagram' => Setting::get('instagram_url', ''),
        ],
    ]);
});

Route::get('/news', function () {
    return Inertia::render('News/Index', [
        'blogs' => Blog::with('translations')->published()->latest()->get(),
        'workingHours' => Section::getData('working_hours'),
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
        'workingHours' => Section::getData('working_hours'),
        'socialLinks' => [
            'facebook' => Setting::get('facebook_url', ''),
            'instagram' => Setting::get('instagram_url', ''),
        ],
    ]);
});

Route::get('/laboratory', function () {
    return Inertia::render('Laboratory', [
        'categories' => LabAnalysisCategory::with(['translations', 'activeAnalyses.translations'])
            ->active()
            ->ordered()
            ->get(),
        'disclaimer' => Section::with('translations')->where('key', 'lab_disclaimer')->first(),
        'workingHours' => Section::getData('working_hours'),
        'socialLinks' => [
            'facebook' => Setting::get('facebook_url', ''),
            'instagram' => Setting::get('instagram_url', ''),
        ],
    ]);
});

Route::get('/daily-dose', function () {
    return Inertia::render('DailyDose/Index', [
        'doses' => DailyDose::with('translations')->published()->latest()->get(),
        'workingHours' => Section::getData('working_hours'),
        'socialLinks' => [
            'facebook' => Setting::get('facebook_url', ''),
            'instagram' => Setting::get('instagram_url', ''),
        ],
    ]);
});

Route::get('/daily-dose/{slug}', function ($slug) {
    $dose = DailyDose::with('translations')->where('slug', $slug)->firstOrFail();
    $dose->incrementViews();
    return Inertia::render('DailyDose/Show', [
        'dose' => $dose,
        'recentDoses' => DailyDose::with('translations')->published()->where('id', '!=', $dose->id)->latest()->take(3)->get(),
        'workingHours' => Section::getData('working_hours'),
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

Route::get('/privacy-policy', function () {
    return Inertia::render('PrivacyPolicy', [
        'socialLinks' => [
            'facebook' => Setting::get('facebook_url', ''),
            'instagram' => Setting::get('instagram_url', ''),
        ],
    ]);
});

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::post('/subscribe', [SubscriberController::class, 'store'])->name('subscribe.store');

// Admin Routes
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('services', ServiceController::class);
    Route::post('/blogs/{blog}/update', [BlogController::class, 'update'])->name('blogs.updatePost');
    Route::post('/blogs/{blog}/convert-image', [BlogController::class, 'convertImage'])->name('blogs.convertImage');
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

    Route::get('/subscribers', [AdminSubscriberController::class, 'index'])->name('subscribers.index');
    Route::delete('/subscribers/{subscriber}', [AdminSubscriberController::class, 'destroy'])->name('subscribers.destroy');

    // Daily Doses
    Route::resource('daily-doses', DailyDoseController::class)->except(['show']);
    Route::post('/daily-doses/{daily_dose}/update', [DailyDoseController::class, 'update'])->name('daily-doses.updatePost');

    // Lab Analyses
    Route::get('/lab-analyses', [LabAnalysisController::class, 'index'])->name('lab-analyses.index');
    Route::get('/lab-analyses/categories/create', [LabAnalysisController::class, 'createCategory'])->name('lab-analyses.categories.create');
    Route::post('/lab-analyses/categories', [LabAnalysisController::class, 'storeCategory'])->name('lab-analyses.categories.store');
    Route::get('/lab-analyses/categories/{category}/edit', [LabAnalysisController::class, 'editCategory'])->name('lab-analyses.categories.edit');
    Route::put('/lab-analyses/categories/{category}', [LabAnalysisController::class, 'updateCategory'])->name('lab-analyses.categories.update');
    Route::delete('/lab-analyses/categories/{category}', [LabAnalysisController::class, 'destroyCategory'])->name('lab-analyses.categories.destroy');
    Route::get('/lab-analyses/categories/{category}/analyses/create', [LabAnalysisController::class, 'createAnalysis'])->name('lab-analyses.analyses.create');
    Route::post('/lab-analyses/categories/{category}/analyses', [LabAnalysisController::class, 'storeAnalysis'])->name('lab-analyses.analyses.store');
    Route::get('/lab-analyses/analyses/{analysis}/edit', [LabAnalysisController::class, 'editAnalysis'])->name('lab-analyses.analyses.edit');
    Route::put('/lab-analyses/analyses/{analysis}', [LabAnalysisController::class, 'updateAnalysis'])->name('lab-analyses.analyses.update');
    Route::delete('/lab-analyses/analyses/{analysis}', [LabAnalysisController::class, 'destroyAnalysis'])->name('lab-analyses.analyses.destroy');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
