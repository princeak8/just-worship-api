<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\SaveMusic;
use App\Http\Requests\UpdateMusic;

use App\Http\Resources\MusicResource;

use App\Services\MusicService;
use App\Services\FileService;

use App\Utilities;

class MusicController extends Controller
{
    private $musicService;
    private $fileService;

    public function __construct()
    {
        $this->musicService = new MusicService;
        $this->fileService = new FileService;
    }

    public function save(SaveMusic $request)
    {
        $data = $request->validated();

        $fileData = [
            "file" => $request->file('coverPhoto'),
            "fileType" => 'image'
        ];
        $file = $this->fileService->save($fileData, 'music');
        $data['coverPhotoId'] = $file->id;

        $music = $this->musicService->save($data);

        return Utilities::ok(new MusicResource($music));
    }

    public function update(UpdateMusic $request, $musicId)
    {
        $data = $request->validated();

        if (!is_numeric($musicId) || !ctype_digit($musicId)) return Utilities::error402("Invalid parameter musicId");

        $music = $this->musicService->getMusic($musicId);
        if(!$music) return Utilities::error402("Music not found");

        $oldCoverPhoto = null;
        
        if($request->hasFile('coverPhoto')) {
            $oldCoverPhoto = $music->coverPhoto;
            $fileData = [
                "file" => $request->file('coverPhoto'),
                "fileType" => 'image'
            ];
            $file = $this->fileService->save($fileData, 'events');
            $data['coverPhotoId'] = $file->id;
        }

        if($oldCoverPhoto) $oldCoverPhoto->delete();

        $music = $this->musicService->update($data, $music);

        return Utilities::ok(new MusicResource($music));
    }

    public function all()
    {
        $music = $this->musicService->getAllMusic();

        return Utilities::ok(MusicResource::collection($music));
    }

    public function music($musicId)
    {
        if (!is_numeric($musicId) || !ctype_digit($musicId)) return Utilities::error402("Invalid parameter musicId");

        $music = $this->musicService->getMusic($musicId);
        if(!$music) return Utilities::error402("Music not found");

        return Utilities::ok(new MusicResource($music));
    }

    public function delete($musicId)
    {
        if (!is_numeric($musicId) || !ctype_digit($musicId)) return Utilities::error402("Invalid parameter musicId");

        $music = $this->musicService->getMusic($musicId);
        if(!$music) return Utilities::error402("Music not found");

        $this->musicService->delete($music);

        return Utilities::okay("Music deleted");
    }
}
