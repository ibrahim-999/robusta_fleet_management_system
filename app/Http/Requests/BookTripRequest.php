<?php

namespace App\Http\Requests;

use App\Models\BusSeat;
use App\Services\BookingService;
use Illuminate\Foundation\Http\FormRequest;

class BookTripRequest extends FormRequest
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
            'start_station' => 'required',
            'finish_station' => 'required',
            'seat_numbers' => 'required|array|max:10',
            'seat_numbers.*' => 'numeric',
            'trip_id' => 'required',
        ];
    }
    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Validation\Validator $validator
     *
     * @return void
     */
    public function withValidator($validator): void
    {
        $validator
            ->after(function ($validator) {
            $available_seats = $this->getAvailableSeats();
            foreach ($this->get('seat_numbers') as $index => $seat_number) {
                if (!in_array($seat_number, $available_seats)) {
                    $validator
                        ->errors()
                        ->add("seat_numbers.$index", 'This seat number is no available for this trip');
                }
            }
        });
    }
    protected function getAvailableSeats(): array
    {
        $busy_seats = app(BookingService::class)
            ->setStartAndFinishStations($this->get('start_station'), $this->get('finish_station'))
            ->getBusySeats($this->get('trip_id'));
        return BusSeat::whereNotIn('id', $busy_seats)
            ->pluck('id')
            ->toArray();
    }
}
