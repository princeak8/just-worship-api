<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use App\Http\Requests\Login;

use App\Http\Resources\UserResource;

use App\Utilities;

class AuthController extends Controller
{
    public function login(Login $request)
    {
        try{
            $credentials = $request->only('email', 'password');
            if (! $token = Auth::attempt($credentials)) {
                return response()->json([
                    'statusCode' => 402,
                    'error' => 'Wrong Username or Password'
                ], 402);
            }
            $user = new UserResource(Auth::user());
            return Utilities::okay('login successful', [
                'token' => $token,
                'token_type' => 'bearer',
                'token_expires_in' => Auth::factory()->getTTL(), 
                'user' => $user
            ]);
        }catch(\Exception $e){
            return Utilities::error($e, 'An error occurred while trying to send verification mail, Please try again later or contact support');
        }
    }
}
