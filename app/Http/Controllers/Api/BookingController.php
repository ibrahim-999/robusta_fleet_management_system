<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookTripRequest;
use App\Http\Requests\GetAvailableSeatsRequest;
use App\Http\Resources\BusTripResource;
use App\Http\Resources\CitiesResource;
use App\Http\Responses\ApiResponse;
use App\Models\BookingStation;
use App\Models\BusTrip;
use App\Models\BusTripStation;
use App\Models\City;
use App\Services\BookingService;
use Illuminate\Http\JsonResponse;

class BookingController extends Controller
{
    protected BookingService $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function getCities()
    {
        return ApiResponse::success([
            'cities' => CitiesResource::collection(City::paginate())
        ]);
    }

    public function getAvailableSeats(GetAvailableSeatsRequest $getAvailableSeatsRequest)
    {
        $busy_seats = $this->bookingService
            ->setStartAndFinishStations(
                $getAvailableSeatsRequest->get('start_station'),
                $getAvailableSeatsRequest->get('finish_station'))
            ->getBusySeats();

        $buses = BusTrip::whereDay('trip_start_date', today())
            ->whereHas('stations', function ($stations_query) use ($busy_seats) {
                $stations_query
                    ->whereIn('city_id', [
                        request('start_station'),
                        request('finish_station')
                    ]);
            })
            ->with('bus', function ($bus_query) use ($busy_seats) {
                $bus_query
                    ->with('seats', function ($seats_query) use ($busy_seats) {
                    $seats_query
                        ->whereNotIn('id', $busy_seats);
                });
            })
            ->with('stations.city')
            ->withCount('stations')
            ->paginate();
        return BusTripResource::collection($buses);
    }

    public function bookTrip(BookTripRequest $bookTripRequest)
    {
        $booking_data = collect($bookTripRequest->validated('seat_numbers'))
            ->map(function ($seat_number) use ($bookTripRequest) {
                return [
                    'bus_trip_id' => $bookTripRequest->validated('trip_id'),
                    'bus_seat_id' => $seat_number,
                    'start_station' => $bookTripRequest->validated('start_station'),
                    'finish_station' => $bookTripRequest->validated('finish_station'),
                ];
            })->toArray();
        $bookings = $bookTripRequest->user()->bookings()
            ->createMany($booking_data);
        $stations = BusTripStation::whereBetween('id',
            [
                $bookTripRequest->validated('start_station'),
                $bookTripRequest->validated('finish_station')
            ])
            ->orderBy('order')->get('id');
        $booking_station_data = [];

        foreach ($bookings as $booking) {
            foreach ($stations as $station) {
                $booking_station_data[] = [
                    'bus_trip_station_id' => $station->id,
                    'booking_id' => $booking->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }
        BookingStation::insert($booking_station_data);
        return ApiResponse::success([], 201);
    }

}
