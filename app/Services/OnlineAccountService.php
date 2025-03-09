<?php

namespace App\Services;

use App\Models\OnlineAccount;

class OnlineAccountService
{
    public function save($data)
    {
        $account = new OnlineAccount;
        if(isset($data['qrCodePhotoId'])) $account->qr_code_photo_id = $data['qrCodePhotoId'];
        $account->name = $data['name'];
        $account->url = $data['url'];
        $account->save();

        return $account;
    }

    public function update($data, $account)
    {
        if(isset($data['qrCodePhotoId'])) $account->qr_code_photo_id = $data['qrCodePhotoId'];
        if(isset($data['url'])) $account->url = $data['url'];
        if(isset($data['name'])) $account->name = $data['name'];
        $account->update();

        return $account;
    }

    public function accounts()
    {
        return OnlineAccount::all();
    }

    public function account($id)
    {
        return OnlineAccount::find($id);
    }

    public function delete($account)
    {
        $account->delete();
    }
}