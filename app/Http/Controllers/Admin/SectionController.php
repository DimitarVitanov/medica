<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SectionController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Sections/Index', [
            'sections' => Section::all(),
        ]);
    }

    public function edit(Section $section)
    {
        return Inertia::render('Admin/Sections/Edit', [
            'section' => [
                'id' => $section->id,
                'key' => $section->key,
                'title' => $section->title,
                'content' => $section->content,
                'data' => $section->data ?? [],
                'is_active' => $section->is_active,
            ],
        ]);
    }

    public function update(Request $request, Section $section)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'section_data' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        $section->update([
            'title' => $validated['title'] ?? $section->title,
            'content' => $validated['content'] ?? $section->content,
            'data' => $validated['section_data'] ?? $section->data,
            'is_active' => $validated['is_active'] ?? $section->is_active,
        ]);

        return redirect()->route('admin.sections.index')->with('success', 'Секцијата е ажурирана.');
    }
}
