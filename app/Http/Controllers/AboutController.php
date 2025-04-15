<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\SaveAbout;

use App\Http\Resources\AboutResource;

use App\Services\AboutService;
use App\Services\FileService;

use App\Utilities;

class AboutController extends Controller
{
    private $aboutService;
    private $fileService;

    public function __construct()
    {
        $this->aboutService = new AboutService;
        $this->fileService = new FileService;
    }

    public function save(SaveAbout $request)
    {
        $data = $request->validated();

        $about = $this->aboutService->about();

        $oldMissionPhoto = null;
        $oldVisionPhoto = null;
        $oldPastorPhoto = null;

        if($request->hasFile('missionPhoto')) {
             if($about && $about->missionPhoto) $oldMissionPhoto = $about->missionPhoto;
            $fileData = [
                "file" => $request->file('missionPhoto'),
                "fileType" => 'image'
            ];
            $file = $this->fileService->save($fileData, 'about');
            $data['missionPhotoId'] = $file->id;
        }

        if($request->hasFile('visionPhoto')) {
            if($about && $about->visionPhoto) $oldVisionPhoto = $about->visionPhoto;
           $fileData = [
               "file" => $request->file('visionPhoto'),
               "fileType" => 'image'
           ];
           $file = $this->fileService->save($fileData, 'about');
           $data['visionPhotoId'] = $file->id;
       }

       if($request->hasFile('pastorPhoto')) {
            if($about && $about->pastorPhoto) $oldPastorPhoto = $about->pastorPhoto;
            $fileData = [
                "file" => $request->file('pastorPhoto'),
                "fileType" => 'image'
            ];
            $file = $this->fileService->save($fileData, 'about');
            $data['pastorPhotoId'] = $file->id;
       }

        $about = $this->aboutService->save($data);

        if($oldMissionPhoto) $oldMissionPhoto->delete();
        if($oldVisionPhoto) $oldVisionPhoto->delete();
        if($oldPastorPhoto) $oldPastorPhoto->delete();

        return Utilities::ok(new AboutResource($about));
    }

    public function about()
    {
        $about = $this->aboutService->about();

        if(!$about) return Utilities::ok(null);

        return Utilities::ok(new AboutResource($about));
    }

}
