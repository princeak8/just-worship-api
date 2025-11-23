<?php
// 4. CREATE A JOB FOR BACKGROUND PROCESSING
// php artisan make:job CompressVideoJob

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Illuminate\Support\Facades\Storage;

class CompressVideoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 3600; // 1 hour timeout
    protected $videoPath;

    protected $fileName;

    public function __construct($videoPath, $fileName)
    {
        $this->videoPath = $videoPath;
        $this->fileName = $fileName;
    }

    public function handle()
    {
        try {
            Log::info("Starting compression for: {$this->videoPath}");

            // Generate compressed filename
            $compressedFilename = pathinfo($this->fileName, PATHINFO_FILENAME) . '_compressed.mp4';
            $compressedPath = 'videos/compressed/' . $compressedFilename;

            // Compress video using FFmpeg
            FFMpeg::fromDisk('public')
                ->open($this->videoPath)
                ->export()
                ->toDisk('public')
                ->inFormat(new \FFMpeg\Format\Video\X264('aac', 'libx264'))
                ->resize(1280, 720) // Resize to 720p
                ->addFilter([
                    '-crf', '23',           // Quality
                    '-preset', 'medium',    // Speed vs compression
                    '-b:a', '128k'         // Audio bitrate
                ])
                ->save($compressedPath);

            Log::info("Compression completed: {$compressedPath}");

            // Delete original video to save space
            Storage::disk('public')->delete($this->videoPath);
            
            Log::info("Original video deleted: {$this->videoPath}");

            // Optional: Fire event or send notification
            // event(new VideoCompressed($compressedPath));

        } catch (\Exception $e) {
            Log::error("Video compression failed: " . $e->getMessage());
            throw $e; // Re-throw to trigger retry
        }
        // $compressedPath = 'videos/compressed/' . time() . '_compressed.mp4';

        // FFMpeg::fromDisk('public')
        //     ->open($this->videoPath)
        //     ->export()
        //     ->toDisk('public')
        //     ->inFormat(new \FFMpeg\Format\Video\X264('aac', 'libx264'))
        //     ->resize(1280, 720)
        //     ->addFilter(['-crf', '23', '-preset', 'medium', '-b:a', '128k'])
        //     ->save($compressedPath);

        // // Delete original
        // Storage::disk('public')->delete($this->videoPath);

        // Optional: Notify user or update database
    }

    /**
     * Handle job failure
     */
    public function failed(\Throwable $exception)
    {
        Log::error("Video compression job failed permanently: " . $exception->getMessage());
        
        // Optional: Notify admin or user
        // Mail::to('admin@example.com')->send(new CompressionFailedMail($this->videoPath));
    }
}