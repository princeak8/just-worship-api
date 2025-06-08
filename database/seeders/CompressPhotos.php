<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Services\FileService;
use App\Models\File;

class CompressPhotos extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fileService = new FileService;
        $manager = ImageManager::imagick(); // ImageManager::gd();; // Create ImageManager instance manually

        $files = File::where("file_type", "image")->get();
        if($files->count() > 0) {
            foreach($files as $file) {
                $urlArr = explode("/", $file->url);

                // Path to the original image (assuming 'public' disk)

                // $path = public_path($file->url); // url($file->url);
                $path = Storage::disk("public")->path('/'.$urlArr[2].'/'.$urlArr[3]);
                if (!file_exists($path)) {
                    dd("photo not found ".$path);
                }
                // Load the image from disk
                $image = $manager->read($path);

                // Compress the image (e.g., to 70% quality)
                $compressed = $image->toWebp(60); // Or 'webp', 'png', etc.

                $filename = pathinfo($urlArr[3], PATHINFO_FILENAME);
                // Compose filename with extension
                $filenameWithExt = $filename . '.webp';

                // Temp file path
                $tempPath = sys_get_temp_dir() . '/' . $filenameWithExt;

                // Save encoded image to temp file
                file_put_contents($tempPath, $compressed);

                $res = $fileService->upload($tempPath, $urlArr[2]."/compressed", $filenameWithExt);

                // Delete temp file
                unlink($tempPath);

                $file->compressed_url = $res['url'];
                $file->update();
            }
        }
    }
}
