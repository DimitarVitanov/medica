<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Services\ImageService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class OptimizeBlogImagesSeeder extends Seeder
{
    public function run(): void
    {
        $imageService = new ImageService();
        
        $blogs = Blog::all();
        
        foreach ($blogs as $blog) {
            if ($blog->image && str_starts_with($blog->image, 'http')) {
                $this->command->info("Processing: {$blog->title}");
                
                try {
                    // Download the image
                    $response = Http::get($blog->image);
                    
                    if ($response->successful()) {
                        // Generate filename from slug
                        $filename = "blogs/{$blog->slug}.webp";
                        
                        // Convert to WebP and save
                        $image = Image::read($response->body());
                        $image->scale(width: 800); // Reasonable size for blog images
                        
                        $webpContent = $image->toWebp(quality: 80)->toString();
                        Storage::disk('public')->put($filename, $webpContent);
                        
                        // Update blog record
                        $blog->image = $filename;
                        $blog->save();
                        
                        // Generate responsive sizes
                        $imageService->generateResponsiveSizes($filename);
                        
                        $this->command->info("  Saved as: {$filename}");
                    }
                } catch (\Exception $e) {
                    $this->command->error("  Failed: " . $e->getMessage());
                }
            }
        }
        
        $this->command->info('Blog images optimization completed!');
    }
}
