<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\AddGalleryPhotos;
use App\Http\Requests\UpdateGalleryPhoto;

use App\Http\Resources\GalleryResource;

use App\Services\GalleryService;
use App\Services\FileService;

use App\Utilities;

class GalleryController extends Controller
{
    private $galleryService;
    private $fileService;

    public function __construct()
    {
        $this->galleryService = new GalleryService;
        $this->fileService = new FileService;
    }

    public function save(AddGalleryPhotos $request)
    {
        $data = $request->validated();
        
        $fileData = [
            "file" => $request->file('photo'),
            "fileType" => 'image'
        ];
        $file = $this->fileService->save($fileData, 'gallery');
        $data['photoId'] = $file->id;

        $galleryPhoto = $this->galleryService->save($data);

        return Utilities::ok(new GalleryResource($galleryPhoto));
    }

    public function update($id, UpdateGalleryPhoto $request)
    {
        if (!is_numeric($id) || !ctype_digit($id)) return Utilities::error402("Invalid parameter id");

        $data = $request->validated();
        $galleryPhoto = $this->galleryService->galleryPhoto($id);

        if(!$galleryPhoto) return Utilities::error402("Gallery Photo not found");
        
        $oldPhoto = null;
        if($request->hasFile('photo')) {
            $oldPhoto = $galleryPhoto->photo;
            $fileData = [
                "file" => $request->file('photo'),
                "fileType" => 'image'
            ];
            $file = $this->fileService->save($fileData, 'slides');
            $data['photoId'] = $file->id;
        }

        $galleryPhoto = $this->galleryService->update($data, $galleryPhoto);
        if($oldPhoto) $oldPhoto->delete();

        return Utilities::ok(new GalleryResource($galleryPhoto));
    }

    public function gallery(Request $request)
    {
        $page = ($request->query('page')) ?? 1;
        $perPage = ($request->query('perPage'));
        if(!is_int((int) $page) || $page <= 0) $page = 1;
        if(!is_int((int) $perPage) || $perPage==null) $perPage = env('PAGINATION_PER_PAGE');
        $offset = $perPage * ($page-1);

        $gallery = $this->galleryService->gallery($offset, $perPage);

        $this->galleryService->count = true;
        $total = $this->galleryService->gallery();

        return Utilities::paginatedOkay(GalleryResource::collection($gallery), $page, $perPage, $total);
    }

    public function galleryPhoto($id)
    {
        if (!is_numeric($id) || !ctype_digit($id)) return Utilities::error402("Invalid parameter id");

        $galleryPhoto = $this->galleryService->galleryPhoto($id);

        if(!$galleryPhoto) return Utilities::error402("Gallery Photo not found");

        return Utilities::ok(new GalleryResource($galleryPhoto));
    }

    public function deleteGalleryPhoto($id)
    {
        if (!is_numeric($id) || !ctype_digit($id)) return Utilities::error402("Invalid parameter id");

        $galleryPhoto = $this->galleryService->galleryPhoto($id);

        if(!$galleryPhoto) return Utilities::error402("Gallery Photo not found");

        $this->galleryService->delete($galleryPhoto);

        return Utilities::okay("Gallery Photo deleted successfully");
    }

}
