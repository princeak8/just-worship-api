<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use App\Models\File;

class FileService
{
    public function upload($file, $folder = 'documents', $filename = null)
    {
        // Define the path where the file will be stored
        $path = $folder.'/'; // You can change this to your desired directory
        if(!$filename) $filename = time() . '_' . $file->getClientOriginalName(); // Create a unique filename

        // Save the file to the local storage using Storage facade
        Storage::disk('public')->putFileAs($path, $file, $filename);

        // Return the public accessible link
        return [
                "url" => Storage::url($path . $filename),
                "filename" => $filename
            ];
    }

    public function save($data, $folder='documents')
    {
        $file = new File;

        $fileArr = $this->upload($data['file'], $folder);

        $size = $data['file']->getSize();

        $compressedUrl = ($size/1000000 > 2) ? $this->compressAndUpload($data['file'], $folder, $fileArr['filename']) : $fileArr['url'];

        $file->url = $fileArr['url'];
        $file->compressed_url = $compressedUrl;
        $file->filename = $fileArr['filename'];
        $file->original_filename = $data['file']->getClientOriginalName();
        $file->extension = $data['file']->getClientOriginalExtension();
        $file->mime_type = $data['file']->getMimeType();
        $file->size = $data['file']->getSize();
        $file->formatted_size = $this->convertSize($file->size);
        $file->file_type = $data['fileType'];

        $file->save();

        return $file;
    }

    public function compressAndUpload($file, $folder, $filename)
    {
        $filename = explode(".", $filename)[0];
        // dd($filename);
        $manager = ImageManager::imagick();

        // Load the image from disk
        $image = $manager->read($file);

        // Compress the image (e.g., to 70% quality)
        $compressed = $image->toWebp(60); // Or 'jpg', 'png', etc.

        $filenameWithExt = $filename . '.webp';

        // Temp file path
        $tempPath = sys_get_temp_dir() . '/' . $filenameWithExt;

        // Save encoded image to temp file
        file_put_contents($tempPath, $compressed);

        $res = $this->upload($tempPath, $folder."/compressed", $filenameWithExt);

        return $res['url'];
    }

    public function delete($file)
    {
        $file->delete();
    }

    private function convertSize($size)
    {
        $formatted = '';
        $len = strlen($size);
        if($len < 4) $formatted = $size.'Bytes'; 
        if($len > 3 && $len < 7) $formatted = round((float)($size/1024), 1).'KB';
        if($len > 6 && $len < 11) $formatted = round((float)(($size/1024)/1024), 1).'MB';
        if($len > 10 && $len < 14) $formatted = round((float)((($size/1024)/1024)/1024), 1).'GB';
        //return (float)$formatted;
        return $formatted;
    }
}