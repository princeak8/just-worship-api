<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnlineAccount extends Model
{
    public function qrCodePhoto()
    {
        return $this->belongsTo(File::class, "qr_code_photo_id", "id");
    }

    public function givingAccounts()
    {
        return $this->hasMany(GivingAccount::class);
    }

    public static function boot ()
    {
        parent::boot();

        self::deleting(function (OnlineAccount $account) {
            if($account->givingAccounts->count() > 0) {
                foreach($account->givingAccounts as $givingAccount) {
                    $givingAccount->delete();
                }
            }
            
            if($account->qrCodePhoto) $account->qrCodePhoto->delete();
        });
    }
}
