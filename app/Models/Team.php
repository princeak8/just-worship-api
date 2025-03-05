<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = "team";

    public function photo()
    {
        return $this->belongsTo(File::class, "photo_id", "id");
    }

    public static function boot ()
    {
        parent::boot();

        self::deleting(function (Team $team) {
            if($team->photo) $team->photo->delete();
        });
    }
}
