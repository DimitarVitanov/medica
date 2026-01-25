<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ImageService
{
    protected array $sizes = [
        'sm' => 480,
        'md' => 768,
        'lg' => 1200,
        'xl' => 1600,
    ];

    public function generateResponsiveSizes(string $originalPath, string $disk = 'public'): array
    {
        $generatedPaths = [];
        
        if (!Storage::disk($disk)->exists($originalPath)) {
            return $generatedPaths;
        }

        $fullPath = Storage::disk($disk)->path($originalPath);
        $pathInfo = pathinfo($originalPath);
        $directory = $pathInfo['dirname'];
        $filename = $pathInfo['filename'];
        $extension = $pathInfo['extension'] ?? 'jpg';

        foreach ($this->sizes as $sizeName => $width) {
            try {
                $image = Image::read($fullPath);
                
                // Only resize if image is larger than target width
                if ($image->width() > $width) {
                    $image->scale(width: $width);
                }

                // Generate WebP version
                $webpPath = "{$directory}/{$filename}-{$sizeName}.webp";
                $webpFullPath = Storage::disk($disk)->path($webpPath);
                $image->toWebp(quality: 85)->save($webpFullPath);
                $generatedPaths["webp_{$sizeName}"] = $webpPath;

                // Generate original format version
                $resizedPath = "{$directory}/{$filename}-{$sizeName}.{$extension}";
                $resizedFullPath = Storage::disk($disk)->path($resizedPath);
                
                if (in_array(strtolower($extension), ['jpg', 'jpeg'])) {
                    $image->toJpeg(quality: 85)->save($resizedFullPath);
                } elseif (strtolower($extension) === 'png') {
                    $image->toPng()->save($resizedFullPath);
                }
                
                $generatedPaths[$sizeName] = $resizedPath;

            } catch (\Exception $e) {
                \Log::error("Failed to generate {$sizeName} size for {$originalPath}: " . $e->getMessage());
            }
        }

        return $generatedPaths;
    }

    public function getSrcset(string $originalPath, string $disk = 'public'): string
    {
        $pathInfo = pathinfo($originalPath);
        $directory = $pathInfo['dirname'];
        $filename = $pathInfo['filename'];
        
        $srcset = [];
        
        foreach ($this->sizes as $sizeName => $width) {
            $webpPath = "{$directory}/{$filename}-{$sizeName}.webp";
            if (Storage::disk($disk)->exists($webpPath)) {
                $srcset[] = "/storage/{$webpPath} {$width}w";
            }
        }

        return implode(', ', $srcset);
    }

    public function getResponsiveImageData(string $originalPath, string $disk = 'public'): array
    {
        $pathInfo = pathinfo($originalPath);
        $directory = $pathInfo['dirname'];
        $filename = $pathInfo['filename'];
        $extension = $pathInfo['extension'] ?? 'jpg';

        $data = [
            'original' => "/storage/{$originalPath}",
            'srcset' => [],
            'webp_srcset' => [],
        ];

        foreach ($this->sizes as $sizeName => $width) {
            // Check for WebP
            $webpPath = "{$directory}/{$filename}-{$sizeName}.webp";
            if (Storage::disk($disk)->exists($webpPath)) {
                $data['webp_srcset'][] = "/storage/{$webpPath} {$width}w";
            }

            // Check for original format
            $resizedPath = "{$directory}/{$filename}-{$sizeName}.{$extension}";
            if (Storage::disk($disk)->exists($resizedPath)) {
                $data['srcset'][] = "/storage/{$resizedPath} {$width}w";
            }
        }

        $data['srcset'] = implode(', ', $data['srcset']);
        $data['webp_srcset'] = implode(', ', $data['webp_srcset']);

        return $data;
    }
}
