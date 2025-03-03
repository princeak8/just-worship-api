<?php

namespace App\Services;

use App\Models\Store;

class StoreService
{
    public function save($data)
    {
        $store = new Store;
        $store->name = $data['name'];
        $store->cover_photo_id = $data['coverPhotoId'];
        $store->price = $data['price'];
        if(isset($data['description'])) $store->description = $data['description'];
        $store->save();

        return $store;
    }

    public function update($data, $store)
    {
        if(isset($data['name'])) $store->name = $data['name'];
        if(isset($data['CoverPhotoId'])) $store->cover_photo_id = $data['coverPhotoId'];
        if(isset($data['price'])) $store->price = $data['price'];
        if(isset($data['description'])) $store->description = $data['description'];
        $store->update();

        return $store;
    }

    public function stores()
    {
        return Store::all();
    }

    public function store($id)
    {
        return Store::find($id);
    }
}