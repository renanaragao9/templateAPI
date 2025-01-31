<?php

namespace App\Services\Auth;

use App\Models\User;

class RegisterService
{
    public function register($data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        return response()->json([
            'message' => 'Usuário registrado com sucesso.',
            'user' => $user,
        ], 201);
    }
}
