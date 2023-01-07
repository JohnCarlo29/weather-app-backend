<?php

namespace App\Services;

use App\Services\Data\GeoLocationData;
use App\Services\Data\WeatherForecastData;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class OpenWeather
{
    const BASE_URL = 'https://api.openweathermap.org';
    const METRIC_UNIT = 'metric';

    /**
     * Api key from https://openweathermap.org/
     *
     * @var string
     */
    private string $appId;

    public function __construct()
    {
        $this->appId = config('services.openweather.api_key');
    }

    public function getForecast(string $location): WeatherForecastData
    {
        $coordinatesData = $this->getGeoCode($location);

        $response = Http::get(self::BASE_URL . '/data/2.5/weather', [
            'lat' => $coordinatesData->lattitude,
            'lon' => $coordinatesData->longhitude,
            'units' => self::METRIC_UNIT,
            'appid' => $this->appId,
        ]);

        $data = $response->json();

        return new WeatherForecastData(
            new GeoLocationData(Arr::get($data, 'coord.lat'),  Arr::get($data, 'coord.lon')),
            Arr::get($data, 'name'),
            Carbon::parse(Arr::get($data, 'dt'))->setTimezone(config('app.timezone'))->toDateTimeString(),
            Arr::get($data, 'weather.0.main'),
            Arr::get($data, 'weather.0.description'),
            Arr::get($data, 'main.temp'),
            Arr::get($data, 'main.temp_min'),
            Arr::get($data, 'main.temp_max'),
            Arr::get($data, 'main.pressure'),
            Arr::get($data, 'main.humidity'),
            Arr::get($data, 'visibility'),
            Arr::get($data, 'wind.speed'),
            Arr::get($data, 'wind.deg'),
            Carbon::parse(Arr::get($data, 'sys.sunrise'))->setTimezone(config('app.timezone'))->toTimeString(),
            Carbon::parse(Arr::get($data, 'sys.sunset'))->setTimezone(config('app.timezone'))->toTimeString(),
        );
    }

    public function getGeoCode(string $location): GeoLocationData
    {
        $params = [
            'q' => $location,
            'appid' => $this->appId
        ];

        $response = Http::get(self::BASE_URL . '/geo/1.0/direct', $params);

        abort_if(empty($response->json()), Response::HTTP_NOT_FOUND, 'Invalid Location');

        $coordinatesData = Arr::only($response->json()[0], ['lat', 'lon']);

        return new GeoLocationData(...array_values($coordinatesData));
    }
}
