<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnlineAccount extends Model
{
    public function qrCodePhoto()
    {
        return $this->belongsTo(File::class, "qr_code_photo_id", "id");
    }

    public static function boot ()
    {
        parent::boot();

        self::deleting(function (OnlineAccount $account) {
            if($account->qrCodePhoto) $account->qrCodePhoto->delete();
        });
    }
}
