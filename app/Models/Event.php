<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function coverPhoto()
    {
        return $this->belongsTo(File::class, "cover_photo_id", "id");
    }

    public function bookings()
    {
        return $this->hasMany(EventBooking::class);
    }

    public static function boot ()
    {
        parent::boot();

        self::deleting(function (Event $event) {
            if($event->coverPhoto) $event->coverPhoto->delete();
        });
    }
}
