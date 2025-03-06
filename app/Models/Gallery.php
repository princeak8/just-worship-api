<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = "gallery";

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

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
