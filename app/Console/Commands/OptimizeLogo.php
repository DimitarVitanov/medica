<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Intervention\Image\Laravel\Facades\Image;

class OptimizeLogo extends Command
{
    protected $signature = 'images:optimize-logo';
    protected $description = 'Convert logo.png to optimized WebP format';

    public function handle(): int
    {
        $logoPath = public_path('images/logo.png');
        
        if (!file_exists($logoPath)) {
            $this->error('Logo not found at: ' . $logoPath);
            return Command::FAILURE;
        }

        $this->info('Optimizing logo...');
        
        try {
            $image = Image::read($logoPath);
            
            // Save as WebP
            $webpPath = public_path('images/logo.webp');
            $image->toWebp(quality: 85)->save($webpPath);
            $this->info('Created: logo.webp');
            
            // Create smaller sizes for responsive
            $sizes = [50, 80, 100, 120];
            foreach ($sizes as $height) {
                $resized = Image::read($logoPath);
                $resized->scale(height: $height);
                $resized->toWebp(quality: 85)->save(public_path("images/logo-{$height}.webp"));
                $this->info("Created: logo-{$height}.webp");
            }
            
            $this->info('Logo optimization completed!');
            return Command::SUCCESS;
            
        } catch (\Exception $e) {
            $this->error('Failed: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
