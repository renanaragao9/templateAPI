<?php

namespace App\Services\Auth;

class LogoutService
{
    public function logout($user)
    {
        $user->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout realizado com sucesso.']);
    }
}
