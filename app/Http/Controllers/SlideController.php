<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\CreateSlide;
use App\Http\Requests\UpdateSlide;

use App\Http\Resources\SlideResource;

use App\Services\SlideService;
use App\Services\FileService;

use App\Utilities;

class SlideController extends Controller
{
    private $slideService;
    private $fileService;

    public function __construct()
    {
        $this->slideService = new SlideService;
        $this->fileService = new FileService;
    }

    public function save(CreateSlide $request)
    {
        $data = $request->validated();
        
        $fileData = [
            "file" => $request->file('photo'),
            "fileType" => 'image'
        ];
        $file = $this->fileService->save($fileData, 'slides');
        $data['photoId'] = $file->id;

        $slide = $this->slideService->save($data);

        return Utilities::ok(new SlideResource($slide));
    }

    public function update($slideId, UpdateSlide $request)
    {
        if (!is_numeric($slideId) || !ctype_digit($slideId)) return Utilities::error402("Invalid parameter slideId");

        $slide = $this->slideService->slide($slideId);
        if(!$slide) return Utilities::error402("Slide not found");
        
        $data = $request->validated();
        $oldPhoto  = null;

        if($request->hasFile('photo')) {
            $oldPhoto = $slide->photo;
            $fileData = [
                "file" => $request->file('photo'),
                "fileType" => 'image'
            ];
            $file = $this->fileService->save($fileData, 'slides');
            $data['photoId'] = $file->id;
        }

        $slide = $this->slideService->update($data, $slide);
        if($oldPhoto) $oldPhoto->delete();

        return Utilities::ok(new SlideResource($slide));
    }

    public function slide($slideId)
    {
        if (!is_numeric($slideId) || !ctype_digit($slideId)) return Utilities::error402("Invalid parameter slideId");

        $slide = $this->slideService->slide($slideId);
        if(!$slide) return Utilities::error402("Slide not found");

        return Utilities::ok(new SlideResource($slide));
    }

    public function slides()
    {
        $slides = $this->slideService->slides();

        return Utilities::ok(SlideResource::collection($slides));
    }

    public function delete($slideId)
    {
        if (!is_numeric($slideId) || !ctype_digit($slideId)) return Utilities::error402("Invalid parameter slideId");

        $slide = $this->slideService->slide($slideId);

        if(!$slide) return Utilities::error402("Slide not found");

        $this->slideService->delete($slide);

        return Utilities::okay("Slide deleted Successfully");
    }
}
