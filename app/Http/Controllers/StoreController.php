<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\AddToStore;
use App\Http\Requests\UpdateStoreItem;

use App\Http\Resources\StoreResource;

use App\Services\StoreService;
use App\Services\FileService;
use App\Utilities;

class StoreController extends Controller
{
    private $storeService;
    private $fileService;

    public function __construct()
    {
        $this->storeService = new StoreService;
        $this->fileService = new FileService;
    }

    public function addToStore(AddToStore $request)
    {
        $data = $request->validated();
        $fileData = [
            "file" => $request->file('coverPhoto'),
            "fileType" => 'image'
        ];
        $file = $this->fileService->save($fileData, 'stores');
        $data['coverPhotoId'] = $file->id;

        $storeItem = $this->storeService->save($data);

        return Utilities::ok(new StoreResource($storeItem));
    }

    public function editItem($id, UpdateStoreItem $request)
    {
        if (!is_numeric($id) || !ctype_digit($id)) return Utilities::error402("Invalid parameter id");

        $item = $this->storeService->store($id);
        if(!$item) return Utilities::error402("Store Item not found");

        $data = $request->validated();
        $oldPhoto  = null;

        if($request->hasFile('coverPhoto')) {
            if($item->coverPhoto) $oldPhoto = $item->coverPhoto;
           $fileData = [
               "file" => $request->file('coverPhoto'),
               "fileType" => 'image'
           ];
           $file = $this->fileService->save($fileData, 'store');
           $data['coverPhotoId'] = $file->id;
       }

       $item = $this->storeService->update($data, $item);
       if($oldPhoto) $oldPhoto->delete();

       return Utilities::ok(new StoreResource($item));
    }

    public function store()
    {
        $store = $this->storeService->stores();

        return Utilities::ok(StoreResource::collection($store));
    }

    public function storeItem($id)
    {
        if (!is_numeric($id) || !ctype_digit($id)) return Utilities::error402("Invalid parameter id");

        $item = $this->storeService->store($id);
        if(!$item) return Utilities::error402("Store Item not found");

        return Utilities::ok(new StoreResource($item));
    }

    public function deleteItem($id)
    {
        if (!is_numeric($id) || !ctype_digit($id)) return Utilities::error402("Invalid parameter id");

        $item = $this->storeService->store($id);
        if(!$item) return Utilities::error402("Store Item not found");

        $this->storeService->delete($item);

        return Utilities::okay("Store Item deleted from store");
    }
}
