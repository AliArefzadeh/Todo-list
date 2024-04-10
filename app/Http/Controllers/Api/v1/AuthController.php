<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create($request->all());
        $loginToken = $user->createToken('loginToken');
        return response()->json([
            'message'=>'User has been registered and an activation link has been sent to your email.',
            'loginToken'=>$loginToken->plainTextToken
        ],201);
    }

    public function login(LoginRequest $request)
    {
        $request->authenticate();
        $loginToken = auth()->user()->createToken('loginToken');

        return response()->json([
            'message'=>'A token has been created',
            'loginToken' => $loginToken->plainTextToken,
        ]);
    }

    public function me()
    {
        return auth()->user();
    }

    public function logout()
    {
      // dd($request->user()->tokens()) ;
        auth()->user()->tokens()->delete();
        return response()->json([
            'meesages' => 'all tokens revoked',
        ]);
    }
}
