<?php

namespace App\Services;

use App\Models\BankAccount;

class BankAccountService
{
    public function save($data)
    {
        $account = new BankAccount;
        $account->country_id = $data['countryId'];
        $account->bank = $data['bank'];
        $account->name = $data['name'];
        $account->number = $data['number'];
        $account->save();

        return $account;
    }

    public function update($data, $account)
    {
        if(isset($data['countryId'])) $account->country_id = $data['countryId'];
        if(isset($data['bank'])) $account->bank = $data['bank'];
        if(isset($data['name'])) $account->name = $data['name'];
        if(isset($data['number'])) $account->number = $data['number'];
        $account->update();

        return $account;
    }

    public function accounts()
    {
        return BankAccount::all();
    }

    public function account($id)
    {
        return BankAccount::find($id);
    }
}