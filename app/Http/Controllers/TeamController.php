<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\AddTeamMember;
use App\Http\Requests\UpdateTeamMember;

use App\Http\Resources\TeamResource;

use App\Services\TeamService;
use App\Services\FileService;

use App\Utilities;

class TeamController extends Controller
{
    private $teamService;
    private $fileService;

    public function __construct()
    {
        $this->teamService = new TeamService;
        $this->fileService = new FileService;
    }

    public function addMember(AddTeamMember $request)
    {
        $data = $request->validated();
        $fileData = [
            "file" => $request->file('photo'),
            "fileType" => 'image'
        ];
        $file = $this->fileService->save($fileData, 'team');
        $data['photoId'] = $file->id;

        $member = $this->teamService->save($data);

        return Utilities::ok(new TeamResource($member));
    }

    public function team()
    {
        $team = $this->teamService->team();

        return Utilities::ok(TeamResource::collection($team));
    }

    public function updateMember($id, UpdateTeamMember $request)
    {
        if (!is_numeric($id) || !ctype_digit($id)) return Utilities::error402("Invalid parameter id");

        $member = $this->teamService->teamMember($id);
        if(!$member) return Utilities::error402("Team Member not found");

        $data = $request->validated();
        $oldPhoto  = null;

        if($request->hasFile('photo')) {
            if($member->photo) $oldPhoto = $member->photo;
           $fileData = [
               "file" => $request->file('photo'),
               "fileType" => 'image'
           ];
           $file = $this->fileService->save($fileData, 'team');
           $data['photoId'] = $file->id;
       }

       $member = $this->teamService->update($data, $member);
       if($oldPhoto) $oldPhoto->delete();

        return Utilities::ok(new TeamResource($member));
    }

    public function teamMember($id)
    {
        if (!is_numeric($id) || !ctype_digit($id)) return Utilities::error402("Invalid parameter id");

        $member = $this->teamService->teamMember($id);

        if(!$member) return Utilities::error402("Team Member not found");

        return Utilities::ok(new TeamResource($member));
    }

    public function removeMember($id)
    {
        if (!is_numeric($id) || !ctype_digit($id)) return Utilities::error402("Invalid parameter id");

        $member = $this->teamService->teamMember($id);
        if(!$member) return Utilities::error402("Team Member not found");

        $this->teamService->delete($member);

        return Utilities::okay("Member removed successfully");
    }
}
