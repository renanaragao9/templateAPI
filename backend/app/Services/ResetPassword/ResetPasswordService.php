<?php

namespace App\Services\ResetPassword;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordService
{
    public function run(array $data)
    {
        $credentials = [
            'email' => $data['email'],
            'password' => $data['password'],
            'token' => $data['token'],
        ];

        $response = Password::reset(
            $credentials,
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($response == Password::PASSWORD_RESET) {
            return [
                'status' => 'success',
                'message' => 'Senha redefinida com sucesso.'
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Token inválido.'
            ];
        }
    }
}
