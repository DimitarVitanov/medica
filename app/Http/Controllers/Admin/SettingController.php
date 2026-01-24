<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Settings/Index', [
            'settings' => Setting::all()->groupBy('group'),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.*.key' => 'required|string',
            'settings.*.value' => 'nullable|string',
        ]);

        $groupMap = [
            'site_name' => 'general',
            'site_phone' => 'general',
            'site_email' => 'general',
            'site_address' => 'general',
            'working_hours' => 'general',
            'facebook_url' => 'social',
            'instagram_url' => 'social',
            'meta_title' => 'seo',
            'meta_description' => 'seo',
            'meta_keywords' => 'seo',
            'og_image' => 'seo',
            'contact_subjects' => 'contact',
            'contact_email' => 'contact',
        ];

        foreach ($validated['settings'] as $setting) {
            $group = $setting['group'] ?? $groupMap[$setting['key']] ?? 'general';
            Setting::set($setting['key'], $setting['value'], 'text', $group);
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Поставките се успешно зачувани.');
    }
}
