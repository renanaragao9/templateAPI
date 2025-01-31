<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auth\LoginService;
use App\Services\Auth\RegisterService;
use App\Services\Auth\LogoutService;
use App\Http\Requests\ResetPassword\ResetPasswordRequest;
use App\Http\Requests\ResetPassword\SendPasswordResetRequest;
use App\Services\ResetPassword\ResetPasswordService;
use App\Services\ResetPassword\SendPasswordLinkService;
use Illuminate\Http\JsonResponse;

class AuthController extends BaseController
{
    protected $loginService;
    protected $registerService;
    protected $logoutService;

    public function __construct(LoginService $loginService, RegisterService $registerService, LogoutService $logoutService)
    {
        $this->loginService = $loginService;
        $this->registerService = $registerService;
        $this->logoutService = $logoutService;
    }

    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();
        return $this->registerService->register($validated);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        return $this->loginService->login($credentials);
    }

    public function logout(Request $request)
    {
        return $this->logoutService->logout($request->user());
    }

    public function user(Request $request)
    {
        return $request->user();
    }

    public function sendResetPasswordLink(
        SendPasswordResetRequest $sendPasswordResetRequest,
        SendPasswordLinkService $sendPasswordLinkService,
    ): JsonResponse {
        $data = $sendPasswordResetRequest->validated();
        $response = $sendPasswordLinkService->run($data['email']);

        if ($response['status'] === 'error') {
            return $this->errorResponse([], $response['message']);
        }

        return $this->successResponse(null, $response['message']);
    }

    public function resetPassword(
        ResetPasswordRequest $resetPasswordRequest,
        ResetPasswordService $resetPasswordService
    ): JsonResponse {
        $data = $resetPasswordRequest->validated();
        $response = $resetPasswordService->run($data);

        if ($response['status'] === 'error') {
            return $this->errorResponse([], $response['message']);
        }

        return $this->successResponse(null, $response['message']);
    }
}
