<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageProcessor
{
    protected ImageManager $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Generate a 800px wide thumbnail for the given public-disk image path.
     * Returns the thumbnail path relative to the public disk.
     */
    public function generateThumbnail(string $imagePath, int $width = 800): string
    {
        $disk = Storage::disk('public');
        $absolutePath = $disk->path($imagePath);

        $image = $this->manager->read($absolutePath);
        $image->scaleDown(width: $width);

        $pathInfo = pathinfo($imagePath);
        $thumbName = $pathInfo['filename'] . '-thumb.jpg';
        $thumbPath = 'gallery/thumbs/' . $thumbName;

        $disk->makeDirectory('gallery/thumbs');
        $image->toJpeg(82)->save($disk->path($thumbPath));

        return $thumbPath;
    }

    /**
     * Optimize and store an uploaded file; returns [image_path, thumbnail_path].
     */
    public function storeUpload(\Illuminate\Http\UploadedFile $file, int $maxWidth = 1920): array
    {
        $disk = Storage::disk('public');
        $disk->makeDirectory('gallery');

        $filename = 'proyecto-' . uniqid() . '.jpg';
        $imagePath = 'gallery/' . $filename;

        $image = $this->manager->read($file->getRealPath());
        $image->scaleDown(width: $maxWidth);
        $image->toJpeg(85)->save($disk->path($imagePath));

        $thumbPath = $this->generateThumbnail($imagePath);

        return [$imagePath, $thumbPath];
    }
}
