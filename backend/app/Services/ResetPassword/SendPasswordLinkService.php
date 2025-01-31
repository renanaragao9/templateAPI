<?php

namespace App\Services\ResetPassword;

use Illuminate\Support\Facades\Password;

class SendPasswordLinkService
{
    public function run(string $email): array
    {
        $status = Password::sendResetLink([
            'email' => $email,
        ]);

        if ($status !== Password::RESET_LINK_SENT) {
            $message = 'Não foi possível enviar o link de redefinição de senha';

            return [
                'status' => 'error',
                'message' => $message,
            ];
        }

        return [
            'status' => 'success',
            'message' => 'Link enviado com sucesso!',
        ];
    }
}
