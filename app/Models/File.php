<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    

    public static function boot ()
    {
        parent::boot();

        self::deleting(function (File $file) {
            Storage::disk('public')->delete($file->url);
            if($file->compressed_url) Storage::disk('public')->delete($file->compressed_url); 
        });
    }
}
