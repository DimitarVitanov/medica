<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\DailyDose;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class DailyDoseController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/DailyDoses/Index', [
            'doses' => DailyDose::latest()->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/DailyDoses/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'title_en' => 'nullable|string|max:255',
            'excerpt_en' => 'nullable|string|max:500',
            'content_en' => 'nullable|string',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,gif,bmp,webp|mimetypes:image/jpeg,image/png,image/gif,image/bmp,image/webp|max:10240',
            'published_at' => 'nullable|date',
            'is_published' => 'boolean',
        ]);

        $translations = [
            'title' => $validated['title_en'] ?? null,
            'excerpt' => $validated['excerpt_en'] ?? null,
            'content' => $validated['content_en'] ?? null,
        ];
        unset($validated['title_en'], $validated['excerpt_en'], $validated['content_en']);

        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);

        if ($request->hasFile('image')) {
            $validated['image'] = ImageHelper::storeAsWebp($request->file('image'), 'daily-doses');
        }

        $dose = DailyDose::create($validated);

        // Save English translations
        foreach ($translations as $field => $value) {
            if ($value !== null && $value !== '') {
                $dose->setTranslation($field, 'en', $value);
            }
        }

        return redirect()->route('admin.daily-doses.index')
            ->with('success', 'Дневната доза е успешно креирана.');
    }

    public function edit(DailyDose $dailyDose)
    {
        return Inertia::render('Admin/DailyDoses/Edit', [
            'dose' => $dailyDose->load('translations'),
        ]);
    }

    public function update(Request $request, DailyDose $dailyDose)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'title_en' => 'nullable|string|max:255',
            'excerpt_en' => 'nullable|string|max:500',
            'content_en' => 'nullable|string',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,gif,bmp,webp|mimetypes:image/jpeg,image/png,image/gif,image/bmp,image/webp|max:10240',
            'published_at' => 'nullable|date',
            'is_published' => 'boolean',
        ]);

        $translations = [
            'title' => $validated['title_en'] ?? null,
            'excerpt' => $validated['excerpt_en'] ?? null,
            'content' => $validated['content_en'] ?? null,
        ];
        unset($validated['title_en'], $validated['excerpt_en'], $validated['content_en']);

        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);

        if ($request->hasFile('image')) {
            if ($dailyDose->image) {
                ImageHelper::deleteResponsiveVariants($dailyDose->image);
                if (Storage::disk('public')->exists($dailyDose->image)) {
                    Storage::disk('public')->delete($dailyDose->image);
                }
            }
            $validated['image'] = ImageHelper::storeAsWebp($request->file('image'), 'daily-doses');
        } else {
            unset($validated['image']);
        }

        $dailyDose->update($validated);

        // Save English translations
        foreach ($translations as $field => $value) {
            $dailyDose->setTranslation($field, 'en', $value ?? '');
        }

        return redirect()->route('admin.daily-doses.index')
            ->with('success', 'Дневната доза е успешно ажурирана.');
    }

    public function destroy(DailyDose $dailyDose)
    {
        if ($dailyDose->image) {
            ImageHelper::deleteResponsiveVariants($dailyDose->image);
            if (Storage::disk('public')->exists($dailyDose->image)) {
                Storage::disk('public')->delete($dailyDose->image);
            }
        }

        $dailyDose->delete();

        return redirect()->route('admin.daily-doses.index')
            ->with('success', 'Дневната доза е успешно избришана.');
    }
}
