<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\CreateDiscipleship;
use App\Http\Requests\UpdateDiscipleship;
use App\Http\Requests\JoinDiscipleship;

use App\Http\Resources\DiscipleshipResource;

use App\Services\DiscipleshipService;
use App\Services\DiscipleshipMemberService;

use App\Utilities;

class DiscipleshipController extends Controller
{
    protected $discipleshipService;
    protected $discipleshipMemberService;

    public function __construct(DiscipleshipService $discipleshipService, DiscipleshipMemberService $discipleshipMemberService)
    {
        $this->discipleshipService = $discipleshipService;
        $this->discipleshipMemberService = $discipleshipMemberService;
    }

    public function discipleships()
    {
        $discipleships = $this->discipleshipService->getDiscipleships();

        return DiscipleshipResource::collection($discipleships);
    }

    public function currentDiscipleship()
    {
        $discipleship = $this->discipleshipService->getCurrentDiscipleship();
        if(!$discipleship) return Utilities::ok([]);

        return Utilities::ok(new DiscipleshipResource($discipleship));
    }

    public function discipleship($discipleshipId)
    {
        if (!is_numeric($discipleshipId) || !ctype_digit($discipleshipId)) return Utilities::error402("Invalid parameter discipleshipId");
            
        $discipleship = $this->discipleshipService->getDiscipleship($discipleshipId);
        if(!$discipleship) return Utilities::ok([]);

        return Utilities::ok(new DiscipleshipResource($discipleship));
    }

    public function create(CreateDiscipleship $request)
    {
        try{
            $data = $request->validated();

            $discipleship = $this->discipleshipService->save($data);
            $discipleship = $this->discipleshipService->getDiscipleship($discipleship->id);

            return Utilities::ok(new DiscipleshipResource($discipleship));
        }catch(\Exception $e){
            return Utilities::error($e, 'An error occurred while trying to process the request, Please try again later or contact support');
        }
    }

    public function update(UpdateDiscipleship $request, $discipleshipId)
    {
        try{
            if (!is_numeric($discipleshipId) || !ctype_digit($discipleshipId)) return Utilities::error402("Invalid parameter discipleshipId");
            
            $discipleship = $this->discipleshipService->getDiscipleship($discipleshipId);
            if(!$discipleship) return Utilities::error402("Discipleship not found");
            
            $data = $request->validated();

            $discipleship = $this->discipleshipService->update($data, $discipleship);

            return Utilities::ok(new DiscipleshipResource($discipleship));
        }catch(\Exception $e){
            return Utilities::error($e, 'An error occurred while trying to process the request, Please try again later or contact support');
        }
    }

    public function open($discipleshipId)
    {
        try{
            if (!is_numeric($discipleshipId) || !ctype_digit($discipleshipId)) return Utilities::error402("Invalid parameter discipleshipId");
            
            $discipleship = $this->discipleshipService->getDiscipleship($discipleshipId);
            if(!$discipleship) return Utilities::error402("Discipleship not found");

            $discipleship = $this->discipleshipService->open($discipleship);

            return Utilities::ok(new DiscipleshipResource($discipleship));
        }catch(\Exception $e){
            return Utilities::error($e, 'An error occurred while trying to process the request, Please try again later or contact support');
        }
    }

    public function close($discipleshipId)
    {
        try{
            if (!is_numeric($discipleshipId) || !ctype_digit($discipleshipId)) return Utilities::error402("Invalid parameter discipleshipId");
            
            $discipleship = $this->discipleshipService->getDiscipleship($discipleshipId);
            if(!$discipleship) return Utilities::error402("Discipleship not found");

            $discipleship = $this->discipleshipService->close($discipleship);

            return Utilities::ok(new DiscipleshipResource($discipleship));
        }catch(\Exception $e){
            return Utilities::error($e, 'An error occurred while trying to process the request, Please try again later or contact support');
        }
    }


    public function join(JoinDiscipleship $request, $discipleshipId)
    {
        try{
            if (!is_numeric($discipleshipId) || !ctype_digit($discipleshipId)) return Utilities::error402("Invalid parameter discipleshipId");
            
            $discipleship = $this->discipleshipService->getDiscipleship($discipleshipId);
            if(!$discipleship) return Utilities::error402("Discipleship not found");

            $data = $request->validated();

            $member = $this->discipleshipMemberService->getMember($discipleship->id, $data['email']);
            if($member) return Utilities::error402("This email has already been registered for this class");

            $this->discipleshipService->join($discipleship, $data);

            return Utilities::okay("You have been registered to the discipleship class successfully");

        }catch(\Exception $e){
            return Utilities::error($e, 'An error occurred while trying to process the request, Please try again later or contact support');
        }
    }
}
