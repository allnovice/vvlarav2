<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\Asset;
use App\Models\AssetPhoto;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage;

#[Signature('app:generate-image-thumbnails')]
#[Description('Command description')]
class GenerateImageThumbnails extends Command
{
    /**
     * Execute the console command.
     */
public function handle(ImageService $imageService): int
{
    $count = 0;

    foreach (Asset::whereNotNull('photo_path')->get() as $asset) {

        if ($asset->photo_thumb_path) {
            continue;
        }

        $thumbPath = 'assets/thumbs/' . basename($asset->photo_path);

        if (!Storage::disk('public')->exists($asset->photo_path)) {
            $this->warn("Missing: {$asset->photo_path}");
            continue;
        }

        $imageService->generateThumbnail(
            $asset->photo_path,
            $thumbPath
        );

        $asset->update([
            'photo_thumb_path' => $thumbPath,
        ]);

        $count++;
    }

    $this->info("Generated {$count} asset thumbnails.");

$photoCount = 0;

foreach (AssetPhoto::whereNotNull('photo_path')->get() as $photo) {

    if ($photo->photo_thumb_path) {
        continue;
    }

    $thumbPath = 'assets/additional/thumbs/' . basename($photo->photo_path);

    if (!Storage::disk('public')->exists($photo->photo_path)) {
        $this->warn("Missing: {$photo->photo_path}");
        continue;
    }

    $imageService->generateThumbnail(
        $photo->photo_path,
        $thumbPath
    );

    $photo->update([
        'photo_thumb_path' => $thumbPath,
    ]);

    $photoCount++;
}

$this->info("Generated {$photoCount} additional photo thumbnails.");

    return self::SUCCESS;
}



}
