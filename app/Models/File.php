<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    

    public static function boot ()
    {
        parent::boot();

        self::deleting(function (File $file) {
            Storage::disk('public')->delete($file->url); 
        });
    }
}
