<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Translation;
use App\Models\Service;
use App\Models\Blog;
use App\Models\Slider;
use App\Models\Section;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TranslationController extends Controller
{
    protected array $supportedLocales = ['mk', 'en'];

    public function index()
    {
        return Inertia::render('Admin/Translations/Index', [
            'services' => Service::with('translations')->ordered()->get(),
            'blogs' => Blog::with('translations')->latest()->get(),
            'sliders' => Slider::with('translations')->ordered()->get(),
            'sections' => Section::with('translations')->get(),
            'locales' => $this->supportedLocales,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'translatable_type' => 'required|string',
            'translatable_id' => 'required|integer',
            'locale' => 'required|string|in:' . implode(',', $this->supportedLocales),
            'field' => 'required|string',
            'value' => 'nullable|string',
        ]);

        Translation::updateOrCreate(
            [
                'translatable_type' => $validated['translatable_type'],
                'translatable_id' => $validated['translatable_id'],
                'locale' => $validated['locale'],
                'field' => $validated['field'],
            ],
            [
                'value' => $validated['value'],
            ]
        );

        return back()->with('success', 'Преводот е зачуван.');
    }

    public function bulkStore(Request $request)
    {
        $validated = $request->validate([
            'translations' => 'required|array',
            'translations.*.translatable_type' => 'required|string',
            'translations.*.translatable_id' => 'required|integer',
            'translations.*.locale' => 'required|string|in:' . implode(',', $this->supportedLocales),
            'translations.*.field' => 'required|string',
            'translations.*.value' => 'nullable|string',
        ]);

        foreach ($validated['translations'] as $translation) {
            Translation::updateOrCreate(
                [
                    'translatable_type' => $translation['translatable_type'],
                    'translatable_id' => $translation['translatable_id'],
                    'locale' => $translation['locale'],
                    'field' => $translation['field'],
                ],
                [
                    'value' => $translation['value'],
                ]
            );
        }

        return back()->with('success', 'Преводите се зачувани.');
    }
}
