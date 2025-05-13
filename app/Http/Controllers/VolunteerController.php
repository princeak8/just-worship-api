<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\Volunteer;
use App\Http\Requests\UpdateVolunteer;

use App\Http\Resources\VolunteerResource;

use App\Services\VolunteerService;
use App\Services\VolunteeringTeamService;

use App\Utilities;

class VolunteerController extends Controller
{
    private $volunteerService;
    private $teamService;

    public function __construct()
    {
        $this->volunteerService = new VolunteerService;
        $this->teamService = new VolunteeringTeamService;
    }

    public function volunteer(Volunteer $request)
    {
        $data = $request->validated();

        $team = $this->teamService->getTeam($data['teamId']);
        if(!$team) return Utilities::error402("Volunteer Team not found");

        $volunteer = $this->volunteerService->getVolunteerByEmail($data['email']);
        if(!$volunteer) {
            $volunteer = $this->volunteerService->save($data);
        }
        $this->volunteerService->joinTeam($volunteer, $team);

        return Utilities::okay("You have joined this Volunteer Team Successfully");
    }

    public function update(UpdateVolunteer $request, $volunteerId)
    {
        $data = $request->validated();

        if (!is_numeric($volunteerId) || !ctype_digit($volunteerId)) return Utilities::error402("Invalid parameter volunteerId");

        $volunteer = $this->volunteerService->getVolunteer($volunteerId);
        if(!$volunteer) return Utilities::error402("Volunteer not found");

        $volunteer = $this->volunteerService->update($data, $volunteer);

        return Utilities::ok(new VolunteerResource($volunteer));
    }

    public function volunteers()
    {
        $volunteers = $this->volunteerService->getVolunteers(['teams']);

        return Utilities::ok(VolunteerResource::collection($volunteers));
    }

    public function getVolunteer($volunteerId)
    {
        if (!is_numeric($volunteerId) || !ctype_digit($volunteerId)) return Utilities::error402("Invalid parameter volunteerId");

        $volunteer = $this->volunteerService->getVolunteer($volunteerId);
        if(!$volunteer) return Utilities::error402("Volunteer not found");

        return Utilities::ok(new VolunteerResource($volunteer));
    }

    public function delete($volunteerId)
    {
        if (!is_numeric($volunteerId) || !ctype_digit($volunteerId)) return Utilities::error402("Invalid parameter volunteerId");

        $volunteer = $this->volunteerService->getVolunteer($volunteerId);
        if(!$volunteer) return Utilities::error402("Volunteer not found");

        $this->volunteerService->delete($volunteer);

        return Utilities::okay("Volunteer Deleted");
    }
}
