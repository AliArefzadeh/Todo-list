<?php

namespace App\Services;

use App\Models\User;

class AuthService
{
    public function generateToken(User $user)
    {
        return $user->createToken('loginToken', $this->getTokenPermissions($user))->plainTextToken;
    }

    public function getTokenPermissions(User $user)
    {
        return $user->email_verified_at !== null ? ['todo:crud'] : [''];
    }
}
