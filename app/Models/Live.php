<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Live extends Model
{
    
    public function coverPhoto()
    {
        return $this->belongsTo(File::class, "cover_photo_id", "id");
    }

    public static function boot ()
    {
        parent::boot();

        self::deleting(function (Live $live) {
            if($live->coverPhoto) $live->coverPhoto->delete();
        });
    }
}
