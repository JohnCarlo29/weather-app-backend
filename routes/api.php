<?php

use App\Http\Controllers\Api\NearByPlaceController;
use App\Http\Controllers\Api\WeatherForecastController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('nearby-places', NearByPlaceController::class)->name('place.nearby');
Route::get('weather', WeatherForecastController::class)->name('place.weather');
