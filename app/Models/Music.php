<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    public function coverPhoto()
    {
        return $this->belongsTo(File::class, "cover_photo_id", "id");
    }
}
