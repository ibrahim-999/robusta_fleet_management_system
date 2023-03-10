<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class GetAvailableSeatsRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'start_station' => 'required|exists:cities,id',
            'finish_station' => 'required|exists:cities,id',
        ];
    }
}
