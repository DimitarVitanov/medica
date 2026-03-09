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

        return $webpPath ?? $path;
    }
}
