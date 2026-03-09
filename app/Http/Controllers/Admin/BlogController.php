<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class BlogController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Blogs/Index', [
            'blogs' => Blog::latest()->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Blogs/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|max:5120',
            'published_at' => 'nullable|date',
            'is_published' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            $validated['image'] = ImageHelper::storeAsWebp($request->file('image'), 'blogs');
        }

        Blog::create($validated);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Блогот е успешно креиран.');
    }

    public function edit(Blog $blog)
    {
        return Inertia::render('Admin/Blogs/Edit', [
            'blog' => $blog,
        ]);
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|max:5120',
            'published_at' => 'nullable|date',
            'is_published' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($blog->image && Storage::disk('public')->exists($blog->image)) {
                Storage::disk('public')->delete($blog->image);
            }
            $validated['image'] = ImageHelper::storeAsWebp($request->file('image'), 'blogs');
        } else {
            unset($validated['image']);
        }

        $blog->update($validated);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Блогот е успешно ажуриран.');
    }

    /**
     * Convert an existing blog image to WebP format.
     */
    public function convertImage(Blog $blog)
    {
        if (!$blog->image) {
            return back()->with('error', 'Блогот нема слика.');
        }

        if (str_ends_with(strtolower($blog->image), '.webp')) {
            return back()->with('success', 'Сликата е веќе во WebP формат.');
        }

        $newPath = ImageHelper::convertToWebp($blog->image);

        if ($newPath) {
            $blog->update(['image' => $newPath]);
            return back()->with('success', 'Сликата е успешно конвертирана во WebP формат.');
        }

        return back()->with('error', 'Грешка при конвертирање на сликата.');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->image && Storage::disk('public')->exists($blog->image)) {
            Storage::disk('public')->delete($blog->image);
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Блогот е успешно избришан.');
    }
}
