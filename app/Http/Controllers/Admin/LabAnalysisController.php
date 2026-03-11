<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LabAnalysis;
use App\Models\LabAnalysisCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class LabAnalysisController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/LabAnalyses/Index', [
            'categories' => LabAnalysisCategory::with(['translations', 'analyses.translations'])
                ->ordered()
                ->get(),
        ]);
    }

    public function createCategory()
    {
        return Inertia::render('Admin/LabAnalyses/CreateCategory');
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $category = LabAnalysisCategory::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'order' => $validated['order'] ?? 0,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        if (!empty($validated['name_en'])) {
            $category->setTranslation('name', 'en', $validated['name_en']);
        }

        return redirect()->route('admin.lab-analyses.index')
            ->with('success', 'Категоријата е успешно креирана.');
    }

    public function editCategory(LabAnalysisCategory $category)
    {
        return Inertia::render('Admin/LabAnalyses/EditCategory', [
            'category' => $category->load('translations'),
        ]);
    }

    public function updateCategory(Request $request, LabAnalysisCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $category->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'order' => $validated['order'] ?? 0,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        $category->setTranslation('name', 'en', $validated['name_en'] ?? '');

        return redirect()->route('admin.lab-analyses.index')
            ->with('success', 'Категоријата е успешно ажурирана.');
    }

    public function destroyCategory(LabAnalysisCategory $category)
    {
        $category->delete();

        return redirect()->route('admin.lab-analyses.index')
            ->with('success', 'Категоријата е успешно избришана.');
    }

    public function createAnalysis(LabAnalysisCategory $category)
    {
        return Inertia::render('Admin/LabAnalyses/CreateAnalysis', [
            'category' => $category,
        ]);
    }

    public function storeAnalysis(Request $request, LabAnalysisCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $analysis = $category->analyses()->create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'order' => $validated['order'] ?? 0,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        if (!empty($validated['name_en'])) {
            $analysis->setTranslation('name', 'en', $validated['name_en']);
        }

        return redirect()->route('admin.lab-analyses.index')
            ->with('success', 'Анализата е успешно додадена.');
    }

    public function editAnalysis(LabAnalysis $analysis)
    {
        return Inertia::render('Admin/LabAnalyses/EditAnalysis', [
            'analysis' => $analysis->load(['translations', 'category']),
        ]);
    }

    public function updateAnalysis(Request $request, LabAnalysis $analysis)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $analysis->update([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'order' => $validated['order'] ?? 0,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        $analysis->setTranslation('name', 'en', $validated['name_en'] ?? '');

        return redirect()->route('admin.lab-analyses.index')
            ->with('success', 'Анализата е успешно ажурирана.');
    }

    public function destroyAnalysis(LabAnalysis $analysis)
    {
        $analysis->delete();

        return redirect()->route('admin.lab-analyses.index')
            ->with('success', 'Анализата е успешно избришана.');
    }
}
