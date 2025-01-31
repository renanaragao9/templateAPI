<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginService
{
    public function login($credentials)
    {
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return response()->json(['message' => 'Email não registrado.'], 404);
        }

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Senha incorreta.'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'message' => 'Login realizado com sucesso.',
            'token' => $token,
            'user' => $user,
        ]);
    }
}
