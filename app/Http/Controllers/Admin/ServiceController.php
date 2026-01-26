<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ServiceController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Services/Index', [
            'services' => Service::ordered()->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Services/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            'icon' => 'nullable|string',
            'color' => 'nullable|string|max:20',
            'image' => 'nullable|image|max:2048',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
            // English translations
            'title_en' => 'nullable|string|max:255',
            'short_description_en' => 'nullable|string|max:500',
            'description_en' => 'nullable|string',
            'features_en' => 'nullable|array',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        // Extract English translations before creating
        $translations = [
            'title' => $request->input('title_en'),
            'short_description' => $request->input('short_description_en'),
            'description' => $request->input('description_en'),
            'features' => $request->input('features_en') ? json_encode($request->input('features_en')) : null,
        ];

        // Remove translation fields from validated data
        unset($validated['title_en'], $validated['short_description_en'], $validated['description_en'], $validated['features_en']);

        $service = Service::create($validated);

        // Save English translations
        foreach ($translations as $field => $value) {
            if ($value !== null && $value !== '') {
                $service->setTranslation($field, 'en', $value);
            }
        }

        return redirect()->route('admin.services.index')
            ->with('success', 'Услугата е успешно креирана.');
    }

    public function edit(Service $service)
    {
        return Inertia::render('Admin/Services/Edit', [
            'service' => $service->load('translations'),
        ]);
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            'icon' => 'nullable|string',
            'color' => 'nullable|string|max:20',
            'image' => 'nullable|image|max:2048',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
            // English translations
            'title_en' => 'nullable|string|max:255',
            'short_description_en' => 'nullable|string|max:500',
            'description_en' => 'nullable|string',
            'features_en' => 'nullable|array',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        // Extract English translations before updating
        $translations = [
            'title' => $request->input('title_en'),
            'short_description' => $request->input('short_description_en'),
            'description' => $request->input('description_en'),
            'features' => $request->input('features_en') ? json_encode($request->input('features_en')) : null,
        ];

        // Remove translation fields from validated data
        unset($validated['title_en'], $validated['short_description_en'], $validated['description_en'], $validated['features_en']);

        $service->update($validated);

        // Save English translations
        foreach ($translations as $field => $value) {
            if ($value !== null && $value !== '') {
                $service->setTranslation($field, 'en', $value);
            }
        }

        return redirect()->route('admin.services.index')
            ->with('success', 'Услугата е успешно ажурирана.');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Услугата е успешно избришана.');
    }
}
