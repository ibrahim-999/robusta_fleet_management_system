<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(LoginRequest $loginRequest): \Illuminate\Http\Response
    {
        try {
            if (auth()->attempt($loginRequest->only('email', 'password'))) {
                auth()->user()->tokens()->delete();

                return ApiResponse::success([
                    'token' => auth()->user()->createToken('login')->plainTextToken
                ]);
            }

            return ApiResponse::forbidden('AUTH_ERROR');
        } catch (\Exception $e) {
            return ApiResponse::fail('SERVER_ERROR', 500);
        }
    }
}
