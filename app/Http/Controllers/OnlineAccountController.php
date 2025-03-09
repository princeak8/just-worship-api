<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\SaveOnlineAccount;
use App\Http\Requests\UpdateOnlineAccount;

use App\Http\Resources\OnlineAccountResource;

use App\Services\OnlineAccountService;
use App\Services\FileService;

use App\Utilities;

class OnlineAccountController extends Controller
{
    private $onlineAccountService;
    private $fileService;

    public function __construct()
    {
        $this->onlineAccountService = new OnlineAccountService;
        $this->fileService = new FileService;
    }

    public function save(SaveOnlineAccount $request)
    {
        $data = $request->validated();

        if($request->hasFile('qrCodePhoto')) {
           $fileData = [
               "file" => $request->file('qrCodePhoto'),
               "fileType" => 'image'
           ];
           $file = $this->fileService->save($fileData, 'qrCode');
           $data['qrCodePhotoId'] = $file->id;
       }

        $onlineAccount = $this->onlineAccountService->save($data);

        return Utilities::ok(new OnlineAccountResource($onlineAccount));
    }

    public function update($onlineAccountId, UpdateOnlineAccount $request)
    {
        if (!is_numeric($onlineAccountId) || !ctype_digit($onlineAccountId)) return Utilities::error402("Invalid parameter onlineAccountId");

        $onlineAccount = $this->onlineAccountService->account($onlineAccountId);
        if(!$onlineAccount) return Utilities::error402("online Account not found");

        $data = $request->validated();
        $oldPhoto  = null;

        if($request->hasFile('qrCodePhoto')) {
            if($onlineAccount->qrCodePhoto) $oldPhoto = $onlineAccount->qrCodePhoto;
           $fileData = [
               "file" => $request->file('qrCodePhoto'),
               "fileType" => 'image'
           ];
           $file = $this->fileService->save($fileData, 'qrCode');
           $data['qrCodePhotoId'] = $file->id;
       }

        $onlineAccount = $this->onlineAccountService->update($data, $onlineAccount);
        if($oldPhoto) $oldPhoto->delete();

        return Utilities::ok(new OnlineAccountResource($onlineAccount));
    }

    public function delete($onlineAccountId)
    {
        if (!is_numeric($onlineAccountId) || !ctype_digit($onlineAccountId)) return Utilities::error402("Invalid parameter onlineAccountId");

        $onlineAccount = $this->onlineAccountService->account($onlineAccountId);
        if(!$onlineAccount) return Utilities::error402("online Account not found");

        $this->onlineAccountService->delete($onlineAccount);

        return Utilities::okay("Online Account deleted Successfully");
    }

    public function account($onlineAccountId)
    {
        if (!is_numeric($onlineAccountId) || !ctype_digit($onlineAccountId)) return Utilities::error402("Invalid parameter onlineAccountId");

        $onlineAccount = $this->onlineAccountService->account($onlineAccountId);
        if(!$onlineAccount) return Utilities::error402("online Account not found");

        return Utilities::ok(new OnlineAccountResource($onlineAccount));
    }

    public function accounts()
    {
        $onlineAccounts = $this->onlineAccountService->accounts();

        return Utilities::ok(OnlineAccountResource::collection($onlineAccounts));
    }
}
