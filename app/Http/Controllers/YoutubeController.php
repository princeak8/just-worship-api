<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\SaveYoutubeVideo;

use App\Http\Resources\YoutubeResource;

use App\Services\YoutubeService;
use App\Models\Youtube;

use App\Utilities;

class YoutubeController extends Controller
{
    private $youtubeService;

    public function __construct()
    {
        $this->youtubeService = new YoutubeService;
    }

    public function save(SaveYoutubeVideo $request)
    {
        $data = $request->validated();

        $youtube = $this->youtubeService->save($data);

        return Utilities::ok(new YoutubeResource($youtube));
    }

    public function youtubeVid()
    {
        $vid = $this->youtubeService->youtube();
        if(!$vid) $vid = new Youtube;

        return Utilities::ok(new YoutubeResource($vid));
    }

    // public function youtubeVid($id)
    // {
    //     $vid = $this->youtubeService->youtube()
    // }

}
