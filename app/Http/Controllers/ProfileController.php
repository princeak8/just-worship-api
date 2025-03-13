<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Resources\UserResource;

use App\Services\UserService;

use App\Utilities;

class ProfileController extends Controller
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService;
    }

    public function profile()
    {
        // if (!is_numeric($userId) || !ctype_digit($userId)) return Utilities::error402("Invalid parameter userId");

        $user = $this->userService->user(Auth::user()->id);

        if(!$user) return Utilities::error402("User not found");

        return Utilities::ok(new UserResource($user));
    }
}
