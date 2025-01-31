<?php

namespace App\Http\Requests\ResetPassword;

use App\Http\Requests\BaseFormRequest;
use App\Models\User;

class ResetPasswordRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                'exists:users',
            ],
            'password' => [
                'required',
                'confirmed',
            ],
            'token' => [
                'required',
                'string',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'O campo de e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ser um endereço de e-mail válido.',
            'email.exists' => 'O e-mail não foi encontrado em nossos registros.',
            'password.required' => 'O campo de senha é obrigatório.',
            'password.confirmed' => 'A confirmação da senha não corresponde.',
            'token.required' => 'O campo de token é obrigatório.',
            'token.string' => 'O token deve ser uma string.',
        ];
    }
}
