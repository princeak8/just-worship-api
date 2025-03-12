<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\SaveMember;

use App\Http\Resources\MembershipResource;

use App\Services\MembershipService;

use App\Utilities;

class MembershipController extends Controller
{
    private $membershipService;

    public function __construct()
    {
        $this->membershipService = new MembershipService;
    }

    public function save(SaveMember $request)
    {
        $data = $request->validated();

        $this->membershipService->save($data);

        return Utilities::okay("Membership Registration was Successful");
    }

    public function members()
    {
        $members = $this->membershipService->members();

        return Utilities::ok(MembershipResource::collection($members));
    }
}
