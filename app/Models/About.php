<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $table = "about";

    public function missionPhoto()
    {
        return $this->belongsTo(File::class, "mission_photo_id", "id");
    }

    public function visionPhoto()
    {
        return $this->belongsTo(File::class, "vision_photo_id", "id");
    }
}
