<?php

namespace App\Http\Requests\FormRequest;

use App\Exceptions\CustomValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

/**
 * A form request that that throws an API validation exception of failure.
 * This is a parent class that should be extended by form requests that handle Api requests.
 */
abstract class ApiFormRequest extends FormRequest
{
    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator): void
    {
        throw (new CustomValidationException($validator));
    }
}
