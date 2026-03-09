<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    /**
     * Convert an image to WebP format.
     *
     * @param string $path  Storage path relative to 'public' disk (e.g. 'blogs/image.jpg')
     * @param int $quality  WebP quality (0-100)
     * @return string|null  New storage path or null on failure
     */
    public static function convertToWebp(string $path, int $quality = 80): ?string
    {
        $fullPath = Storage::disk('public')->path($path);

        if (!file_exists($fullPath)) {
            return null;
        }

        $imageInfo = @getimagesize($fullPath);
        if (!$imageInfo) {
            return null;
        }

        $mime = $imageInfo['mime'];

        // Already webp
        if ($mime === 'image/webp') {
            return $path;
        }

        $image = match ($mime) {
            'image/jpeg', 'image/jpg' => @imagecreatefromjpeg($fullPath),
            'image/png' => @imagecreatefrompng($fullPath),
            'image/gif' => @imagecreatefromgif($fullPath),
            'image/bmp' => @imagecreatefrombmp($fullPath),
            default => null,
        };

        if (!$image) {
            return null;
        }

        // Preserve transparency for PNG
        if ($mime === 'image/png') {
            imagepalettetotruecolor($image);
            imagealphablending($image, true);
            imagesavealpha($image, true);
        }

        // Build new path with .webp extension
        $pathInfo = pathinfo($path);
        $newPath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '.webp';
        $newFullPath = Storage::disk('public')->path($newPath);

        $success = imagewebp($image, $newFullPath, $quality);
        imagedestroy($image);

        if (!$success) {
            return null;
        }

        // Delete original file
        Storage::disk('public')->delete($path);

        return $newPath;
    }

    /**
     * Generate responsive image variants (xs, sm, md, lg, xl) from a WebP image.
     *
     * @param string $path  Storage path relative to 'public' disk (e.g. 'blogs/image.webp')
     * @param int $quality  WebP quality (0-100)
     */
    public static function generateResponsiveVariants(string $path, int $quality = 80): void
    {
        $fullPath = Storage::disk('public')->path($path);

        if (!file_exists($fullPath)) {
            return;
        }

        $imageInfo = @getimagesize($fullPath);
        if (!$imageInfo) {
            return;
        }

        $originalWidth = $imageInfo[0];
        $originalHeight = $imageInfo[1];
        $mime = $imageInfo['mime'];

        $sizes = [
            'xs' => 320,
            'sm' => 480,
            'md' => 768,
            'lg' => 1024,
            'xl' => 1280,
        ];

        $pathInfo = pathinfo($path);
        $baseName = $pathInfo['filename'];
        $directory = $pathInfo['dirname'];

        foreach ($sizes as $suffix => $targetWidth) {
            if ($targetWidth >= $originalWidth) {
                $targetWidth = $originalWidth;
            }

            $ratio = $targetWidth / $originalWidth;
            $targetHeight = (int) round($originalHeight * $ratio);

            // Create image resource from the source file
            $source = null;
            if ($mime === 'image/webp') {
                $source = @imagecreatefromwebp($fullPath);
            } elseif (in_array($mime, ['image/jpeg', 'image/jpg'])) {
                $source = @imagecreatefromjpeg($fullPath);
            } elseif ($mime === 'image/png') {
                $source = @imagecreatefrompng($fullPath);
            }

            if (!$source) {
                continue;
            }

            $resized = imagecreatetruecolor($targetWidth, $targetHeight);

            // Preserve transparency
            imagealphablending($resized, false);
            imagesavealpha($resized, true);

            imagecopyresampled($resized, $source, 0, 0, 0, 0, $targetWidth, $targetHeight, $originalWidth, $originalHeight);

            $variantPath = Storage::disk('public')->path("{$directory}/{$baseName}-{$suffix}.webp");
            @imagewebp($resized, $variantPath, $quality);

            imagedestroy($source);
            imagedestroy($resized);
        }
    }

    /**
     * Delete responsive variants for an image.
     *
     * @param string $path  Storage path relative to 'public' disk
     */
    public static function deleteResponsiveVariants(string $path): void
    {
        $pathInfo = pathinfo($path);
        $baseName = $pathInfo['filename'];
        $directory = $pathInfo['dirname'];

        foreach (['xs', 'sm', 'md', 'lg', 'xl'] as $suffix) {
            $variantPath = "{$directory}/{$baseName}-{$suffix}.webp";
            if (Storage::disk('public')->exists($variantPath)) {
                Storage::disk('public')->delete($variantPath);
            }
        }
    }

    /**
     * Store an uploaded image, convert to WebP, and return the storage path.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $directory  Storage directory (e.g. 'blogs')
     * @param int $quality
     * @return string  Storage path of the WebP image
     */
    public static function storeAsWebp($file, string $directory, int $quality = 80): string
    {
        // Store original first
        $path = $file->store($directory, 'public');

        // Convert to webp
        $webpPath = static::convertToWebp($path, $quality);
        $finalPath = $webpPath ?? $path;

        // Generate responsive variants
        static::generateResponsiveVariants($finalPath, $quality);

        return $finalPath;
    }
}
