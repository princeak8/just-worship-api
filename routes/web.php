<?php

use Illuminate\Support\Facades\Route;

use App\Models\GivingPartner;
use App\Models\BankAccount;
use App\Models\OnlineAccount;

Route::get('/', function () {
    // return view('welcome');
    $partner = GivingPartner::first();
    $bankAccounts = BankAccount::all();
    $onlineAccounts = OnlineAccount::all();
    return view('emails.giving-partner-welcome', compact("partner", "bankAccounts", "onlineAccounts"));
});
