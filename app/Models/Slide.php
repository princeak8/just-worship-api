<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    public function photo()
    {
        return $this->belongsTo(File::class, "photo_id", "id");
    }

    public static function boot ()
    {
        parent::boot();

        self::deleting(function (Slide $slide) {
            if($slide->photo) $slide->photo->delete();
        });
    }
}
