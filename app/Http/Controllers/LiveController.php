<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests\AddLive;
use App\Http\Requests\UpdateLive;
use App\Http\Requests\BookLive;

use App\Http\Resources\LiveResource;

use App\Services\LiveService;
use App\Services\FileService;

use App\Utilities;

class LiveController extends Controller
{
    private $liveService;
    private $fileService;

    public function __construct()
    {
        $this->liveService = new LiveService;
        $this->fileService = new FileService;
    }

    public function save(AddLive $request)
    {
        try{
            $data = $request->validated();
            
            $fileData = [
                "file" => $request->file('coverPhoto'),
                "fileType" => 'image'
            ];

            DB::beginTransaction();

            $file = $this->fileService->save($fileData, 'lives');
            $data['coverPhotoId'] = $file->id;

            $event = $this->liveService->save($data);

            DB::commit();
            
            return Utilities::ok(new LiveResource($event));
        }catch (\Exception $e) {
            return Utilities::error($e, 'An error occurred while attempting to carry out this operation');
        }
    }

    public function update($liveId, UpdateLive $request)
    {
        if (!is_numeric($liveId) || !ctype_digit($liveId)) return Utilities::error402("Invalid parameter liveId");

        $live = $this->liveService->live($liveId);
        if(!$live) return Utilities::error402("Live not found");

        $data = $request->validated();
        $oldCoverPhoto = null;
        
        if($request->hasFile('coverPhoto')) {
            $oldCoverPhoto = $live->coverPhoto;
            $fileData = [
                "file" => $request->file('coverPhoto'),
                "fileType" => 'image'
            ];
            $file = $this->fileService->save($fileData, 'lives');
            $data['coverPhotoId'] = $file->id;
        }

        $live = $this->liveService->update($data, $live);

        if($oldCoverPhoto) $oldCoverPhoto->delete();

        return Utilities::ok(new LiveResource($live));
    }

    public function live($liveId)
    {
        if (!is_numeric($liveId) || !ctype_digit($liveId)) return Utilities::error402("Invalid parameter liveId");

        $live = $this->liveService->live($liveId);
        if(!$live) return Utilities::error402("Live not found");

        return Utilities::ok(new EventResource($live));
    }

    public function lives()
    {
        $lives = $this->liveService->lives();

        return Utilities::ok(LiveResource::collection($lives));
    }

    public function delete($liveId)
    {
        if (!is_numeric($liveId) || !ctype_digit($liveId)) return Utilities::error402("Invalid parameter liveId");

        $live = $this->liveService->live($liveId);
        if(!$live) return Utilities::error402("Live not found");

        $this->liveService->delete($live);

        return Utilities::okay("Live deleted Successfully");
    }
}
