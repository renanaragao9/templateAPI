<?php

namespace App\Http\Requests\ResetPassword;

use App\Http\Requests\BaseFormRequest;

class SendPasswordResetRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                'exists:users,email',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'email.exists' => 'O email fornecido não existe em nossos registros.',
        ];
    }
}
