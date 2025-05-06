<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\SaveMusic;
use App\Http\Requests\UpdateMusic;

use App\Http\Resources\MusicResource;

use App\Services\MusicService;

use App\Utilities;

class MusicController extends Controller
{
    private $musicService;

    public function __construct()
    {
        $this->musicService = new MusicService;
    }

    public function save(SaveMusic $request)
    {
        $data = $request->validated();

        $music = $this->musicService->save($data);

        return Utilities::ok(new MusicResource($music));
    }

    public function update(UpdateMusic $request, $musicId)
    {
        $data = $request->validated();

        if (!is_numeric($musicId) || !ctype_digit($musicId)) return Utilities::error402("Invalid parameter musicId");

        $music = $this->musicService->getMusic($musicId);
        if(!$music) return Utilities::error402("Music not found");

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
