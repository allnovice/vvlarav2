<?php

namespace App\Services;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class ImageService
{

public function storeAssetPhoto($photo): array
{
    $photoPath = $photo->store('assets', 'public');

    $thumbPath = 'assets/thumbs/' . basename($photoPath);

    $manager = ImageManager::usingDriver(Driver::class);

    $image = $manager->decodeSplFileInfo($photo);

    Storage::disk('public')->makeDirectory('assets/thumbs');

    $image
        ->cover(200, 200)
        ->save(
            Storage::disk('public')->path($thumbPath),
            quality: 85
        );

    return [
        'photo_path' => $photoPath,
        'photo_thumb_path' => $thumbPath,
    ];
}
public function approvePendingPhoto(string $pendingPath): array
{
    $disk = Storage::disk('public');

    $filename = basename($pendingPath);

    $photoPath = 'assets/additional/' . $filename;
    $thumbPath = 'assets/additional/thumbs/' . $filename;

    $disk->makeDirectory('assets/additional');
    $disk->makeDirectory('assets/additional/thumbs');

    // Move original
    $disk->move($pendingPath, $photoPath);

    $this->generateThumbnail($photoPath, $thumbPath);

    return [
        'photo_path' => $photoPath,
        'photo_thumb_path' => $thumbPath,
    ];
}
public function generateThumbnail(
    string $sourcePath,
    string $thumbPath
): void
{
    $disk = Storage::disk('public');

    $manager = ImageManager::usingDriver(Driver::class);

    $image = $manager->decodeSplFileInfo(
        new \SplFileInfo($disk->path($sourcePath))
    );

    $directory = dirname($thumbPath);

    logger()->info('Thumbnail directory', [
        'directory' => $directory,
        'exists_before' => $disk->exists($directory),
    ]);

    if (! $disk->exists($directory)) {
        $disk->makeDirectory($directory);
    }

    logger()->info('Directory creation result', [
        'exists_after' => $disk->exists($directory),
    ]);

    $image
        ->cover(200, 200)
        ->save(
            $disk->path($thumbPath),
            quality: 85
        );
}


}
