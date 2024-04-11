<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create($request->all());
        $loginToken = $this->authService->generateToken($user);

        return response()->json([
            'message' => 'User has been registered and an activation link will be sent to your email.',
            'loginToken' => $loginToken,
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $request->authenticate();
        $loginToken = $this->authService->generateToken(auth()->user());

        return response()->json([
            'message' => 'A token has been created',
            'loginToken' => $loginToken,
        ]);
    }

    public function me()
    {
        return response()->json([
            auth()->user()
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'message' => 'All tokens have been revoked.',
        ]);
    }
}
