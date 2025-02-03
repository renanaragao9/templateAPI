<?php

namespace App\Http\Controllers\API;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SocialAuthController extends BaseController
{
    // Redirecionar para o Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::updateOrCreate(
                ['email' => $googleUser->email],
                [
                    'name' => $googleUser->name,
                    'provider_id' => $googleUser->id,
                    'provider' => 'google',
                    'password' => Hash::make(Str::random(16)),
                ]
            );

            $token = $user->createToken('authToken')->plainTextToken;

            // Redireciona para o frontend com o token
            return redirect()->away(env('VUE_APP_API_URL') . '/login?token=' . $token);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Falha na autenticação com o Google'], 500);
        }
    }

    // Redirecionar para o Microsoft
    public function redirectToMicrosoft()
    {
        return Socialite::driver('microsoft')->stateless()->redirect();
    }

    // Callback do Microsoft
    public function handleMicrosoftCallback()
    {
        try {
            $microsoftUser = Socialite::driver('microsoft')->stateless()->user();

            $user = User::updateOrCreate(
                ['email' => $microsoftUser->email],
                [
                    'name' => $microsoftUser->name,
                    'provider_id' => $microsoftUser->id,
                    'provider' => 'microsoft',
                    'password' => Hash::make(Str::random(16)), // Senha aleatória
                ]
            );

            $token = $user->createToken('authToken')->plainTextToken;

            // Redireciona para o frontend com o token
            return redirect()->away(env('VUE_APP_API_URL') . '/login?token=' . $token);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Falha na autenticação com o Microsoft'], 500);
        }
    }
}
