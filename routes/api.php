<?php

use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')
    ->group(function () {
        Route::post('login', [LoginController::class, 'login']);

        Route::middleware('auth:sanctum')->prefix('booking')
            ->controller(BookingController::class)
            ->group(function () {
                Route::get('cities', 'getCities');
                Route::get('available-seats', 'getAvailableSeats');
                Route::post('book-ride', 'bookTrip');
            });

    });
