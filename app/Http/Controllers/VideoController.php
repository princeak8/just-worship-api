<?php

// 1. INSTALL REQUIRED PACKAGE
// Run in terminal: composer require pbmedia/laravel-ffmpeg

// 2. PUBLISH CONFIG (optional)
// php artisan vendor:publish --provider="ProtoneMedia\LaravelFFMpeg\Support\ServiceProvider"

// 3. CREATE A CONTROLLER
// php artisan make:controller VideoController

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;

class VideoController extends Controller
{
    /**
     * Upload and compress video
     */
    public function upload(Request $request)
    {
        $request->validate([
            'video' => 'required|mimes:mp4,avi,mov|max:512000' // 500MB max
        ]);

        try {
            // Store original video temporarily
            $video = $request->file('video');
            $filename = time() . '_' . $video->getClientOriginalName();
            $originalPath = $video->storeAs('videos/original', $filename, 'public');

            // Define compressed video path
            $compressedFilename = time() . '_compressed.mp4';
            $compressedPath = 'videos/compressed/' . $compressedFilename;

            // Compress video
            FFMpeg::fromDisk('public')
                ->open($originalPath)
                ->export()
                ->toDisk('public')
                ->inFormat(new \FFMpeg\Format\Video\X264('aac', 'libx264'))
                ->resize(1280, 720) // Resize to 720p
                ->addFilter([
                    '-crf', '23',           // Quality (18-28, lower = better)
                    '-preset', 'medium',     // Speed vs compression
                    '-b:a', '128k'          // Audio bitrate
                ])
                ->save($compressedPath);

            // Optional: Delete original to save space
            Storage::disk('public')->delete($originalPath);

            return response()->json([
                'success' => true,
                'message' => 'Video compressed successfully',
                'path' => Storage::url($compressedPath),
                'url' => asset('storage/' . $compressedPath)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Compression failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Compress existing video (for already uploaded videos)
     */
    public function compressExisting($videoPath)
    {
        try {
            $compressedPath = 'videos/compressed/' . time() . '_compressed.mp4';

            FFMpeg::fromDisk('public')
                ->open($videoPath)
                ->export()
                ->toDisk('public')
                ->inFormat(new \FFMpeg\Format\Video\X264('aac', 'libx264'))
                ->resize(1280, 720)
                ->addFilter(['-crf', '23', '-preset', 'medium'])
                ->save($compressedPath);

            return response()->json([
                'success' => true,
                'compressed_path' => $compressedPath,
                'url' => asset('storage/' . $compressedPath)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Queue compression for background processing (RECOMMENDED for large files)
     */
    // public function uploadWithQueue(Request $request)
    // {
    //     $request->validate([
    //         'video' => 'required|mimes:mp4,avi,mov|max:512000'
    //     ]);

    //     $video = $request->file('video');
    //     $filename = time() . '_' . $video->getClientOriginalName();
    //     $path = $video->storeAs('videos/original', $filename, 'public');

    //     // Dispatch job to queue
    //     \App\Jobs\CompressVideoJob::dispatch($path);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Video uploaded. Compression in progress...',
    //         'original_path' => $path
    //     ]);
    // }


    /**
     * Upload video in chunks with queue compression
     * This handles large files (200MB+) by uploading in small pieces
     */
    public function uploadWithQueue(Request $request)
    {
        // Create file receiver
        $receiver = new FileReceiver("video", $request, HandlerFactory::classFromRequest($request));

        // Check if upload is successful
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }

        // Receive the file
        $save = $receiver->receive();

        // Check if upload is finished
        if ($save->isFinished()) {
            // File upload is complete
            return $this->saveFile($save->getFile());
        }

        // Upload is still in progress
        $handler = $save->handler();
        
        return response()->json([
            "done" => $handler->getPercentageDone(),
            "status" => "uploading"
        ]);
    }

    /**
     * Save the uploaded file and queue compression
     */
    protected function saveFile($file)
    {
        $fileName = $this->createFilename($file);
        
        // Store the file
        $disk = Storage::disk('public');
        $path = $file->storeAs('videos/original', $fileName, 'public');

        // Delete the temporary chunk files
        $this->deleteTempChunks($file);

        // Dispatch compression job to queue
        \App\Jobs\CompressVideoJob::dispatch($path, $fileName);

        return response()->json([
            'success' => true,
            'message' => 'Video uploaded successfully. Compression queued.',
            'path' => $path,
            'filename' => $fileName,
            'status' => 'processing'
        ], 200);
    }

    /**
     * Create unique filename
     */
    protected function createFilename($file)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = str_replace("." . $extension, "", $file->getClientOriginalName());
        $filename = preg_replace('/[^A-Za-z0-9\-]/', '', $filename);
        
        return $filename . '_' . time() . '.' . $extension;
    }

    /**
     * Delete temporary chunk files
     */
    protected function deleteTempChunks($file)
    {
        $path = $file->getPath();
        
        if (file_exists($path)) {
            @unlink($path);
        }
    }

    /**
     * Check compression status
     * Frontend can poll this endpoint to check if video is ready
     */
    public function checkStatus($filename)
    {
        $compressedPath = 'videos/compressed/' . pathinfo($filename, PATHINFO_FILENAME) . '_compressed.mp4';
        
        if (Storage::disk('public')->exists($compressedPath)) {
            return response()->json([
                'status' => 'completed',
                'url' => asset('storage/' . $compressedPath),
                'path' => $compressedPath
            ]);
        }

        return response()->json([
            'status' => 'processing',
            'message' => 'Video is still being compressed...'
        ]);
    }

    /**
     * List all videos
     */
    public function index()
    {
        $videos = Storage::disk('public')->files('videos/compressed');
        
        $videoList = array_map(function($video) {
            return [
                'filename' => basename($video),
                'url' => asset('storage/' . $video),
                'size' => Storage::disk('public')->size($video),
                'created_at' => Storage::disk('public')->lastModified($video)
            ];
        }, $videos);

        return response()->json([
            'videos' => $videoList
        ]);
    }
}



// 5. ADD ROUTES (routes/api.php or routes/web.php)
/*
Route::post('/video/upload', [VideoController::class, 'upload']);
Route::post('/video/upload-queue', [VideoController::class, 'uploadWithQueue']);
Route::post('/video/compress/{path}', [VideoController::class, 'compressExisting']);
*/