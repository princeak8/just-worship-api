<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\SaveVolunteeringTeam;
use App\Http\Requests\UpdateVolunteeringTeam;

use App\Http\Resources\VolunteeringTeamResource;

use App\Services\VolunteeringTeamService;

use App\Utilities;

class VolunteeringTeamController extends Controller
{
    private $teamService;

    public function __construct()
    {
        $this->teamService = new VolunteeringTeamService;
    }

    public function save(SaveVolunteeringTeam $request)
    {
        $data = $request->validated();

        $team = $this->teamService->save($data);

        return Utilities::ok(new VolunteeringTeamResource($team));
    }

    public function update(UpdateVolunteeringTeam $request, $teamId)
    {
        $data = $request->validated();

        if (!is_numeric($teamId) || !ctype_digit($teamId)) return Utilities::error402("Invalid parameter teamId");

        $team = $this->teamService->getTeam($teamId);
        if(!$team) return Utilities::error402("Volunteering Team not found!");

        $team = $this->teamService->update($data, $team);

        return Utilities::ok(new VolunteeringTeamResource($team));
    }

    public function delete($teamId)
    {
        if (!is_numeric($teamId) || !ctype_digit($teamId)) return Utilities::error402("Invalid parameter teamId");

        $team = $this->teamService->getTeam($teamId);
        if(!$team) return Utilities::error402("Volunteering Team not found!");

        $this->teamService->delete($team);

        return Utilities::okay("Volunteering Team Deleted");
    }

    public function team($teamId)
    {
        if (!is_numeric($teamId) || !ctype_digit($teamId)) return Utilities::error402("Invalid parameter teamId");

        $team = $this->teamService->getTeam($teamId);
        if(!$team) return Utilities::error402("Volunteering Team not found!");

        return Utilities::ok(new VolunteeringTeamResource($team));
    }

    public function teams()
    {
        $teams = $this->teamService->getAllTeam(['volunteers']);

        return Utilities::ok(VolunteeringTeamResource::collection($teams));
    }
}
