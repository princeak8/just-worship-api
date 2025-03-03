<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    public function country()
    {
        return $this->belongsTo(COuntry::class);
    }
}
