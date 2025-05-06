<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function photo()
    {
        return $this->belongsTo(File::class, "photo_id", "id");
    }
}
