<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CurrentWeatherRequest;
use Facades\App\Services\OpenWeather;

class WeatherForecastController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\CurrentWeatherRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(CurrentWeatherRequest $request)
    {
        $weather = OpenWeather::getForecast($request->place);
        return response()->json($weather);
    }
}
