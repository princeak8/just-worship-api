<?php

namespace App\Services;

use App\Models\GivingAccount;
use App\Models\GivingMode;
use App\Models\GivingOption;

class GivingService
{
    public function modes()
    {
       return GivingMode::all();
    }

    public function options()
    {
       return GivingOption::all();
    }

    public function saveGivingAccount($data)
    {
        $account = new GivingAccount;

        if(isset($data['bankAccountId'])) $account->bank_account_id = $data['bankAccountId'];
        if(isset($data['onlineAccountId'])) $account->online_account_id = $data['onlineAccountId'];
        $account->giving_option_id = $data['givingOptionId'];

        $account->save();

        return $account;
    }

    public function getOptionGivingAccount($optionId, $accountId, $type)
    {
        if($type=='bank') return GivingAccount::where("giving_option_id", $optionId)->where("bank_account_id", $accountId)->first();
        if($type=='online') return GivingAccount::where("giving_option_id", $optionId)->where("online_account_id", $accountId)->first();
        return null;
    }
}