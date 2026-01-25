<?php

namespace App\Console\Commands;

use App\Models\Slider;
use App\Models\Blog;
use App\Services\ImageService;
use Illuminate\Console\Command;

class GenerateResponsiveImages extends Command
{
    protected $signature = 'images:generate-responsive {--model=all : Model to process (slider, blog, all)}';
    protected $description = 'Generate responsive image sizes for sliders and blogs';

    public function handle(ImageService $imageService): int
    {
        $model = $this->option('model');

        if ($model === 'all' || $model === 'slider') {
            $this->info('Processing sliders...');
            $sliders = Slider::whereNotNull('image')->get();
            
            foreach ($sliders as $slider) {
                if ($slider->image && !str_starts_with($slider->image, 'http')) {
                    $this->line("  Processing: {$slider->image}");
                    $paths = $imageService->generateResponsiveSizes($slider->image);
                    $this->info("    Generated " . count($paths) . " sizes");
                }
            }
        }

        if ($model === 'all' || $model === 'blog') {
            $this->info('Processing blogs...');
            $blogs = Blog::whereNotNull('image')->get();
            
            foreach ($blogs as $blog) {
                if ($blog->image && !str_starts_with($blog->image, 'http')) {
                    $this->line("  Processing: {$blog->image}");
                    $paths = $imageService->generateResponsiveSizes($blog->image);
                    $this->info("    Generated " . count($paths) . " sizes");
                }
            }
        }

        $this->info('Done!');
        return Command::SUCCESS;
    }
}
