<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    public function coverPhoto()
    {
        return $this->belongsTo(File::class, "cover_photo_id", "id");
    }

    public static function boot ()
    {
        parent::boot();

        self::deleting(function (Store $store) {
            if($store->coverPhoto) $store->coverPhoto->delete();
        });
    }
}
