<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    public function country()
    {
        return $this->belongsTo(COuntry::class);
    }
}
