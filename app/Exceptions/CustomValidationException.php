<?php

namespace App\Exceptions;

use App\Http\Responses\ApiResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class CustomValidationException extends ValidationException
{
    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function render(): Response
    {
        $error_messages = $this->validator->errors()->toArray();

        return ApiResponse::fail($error_messages, 422);
    }
}
