<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(LoginRequest $loginRequest)
    {
        if (auth()->attempt($loginRequest->only('email', 'password'))) {
            auth()
                ->user()
                ->tokens()
                ->delete();
            return ApiResponse::success([
                'token' => auth()
                    ->user()
                    ->createToken('login')->plainTextToken
            ]);
        }
        return ApiResponse::fail('invalid credentials');
    }
}
