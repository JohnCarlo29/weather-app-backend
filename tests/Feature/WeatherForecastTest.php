<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class WeatherForecastTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function canGetCurrentWeatherForecast()
    {
        $this->getJson(route('place.weather', ['place' => 'Osaka']))
            ->assertOk()
            ->assertJsonStructure([
                'geoCode',
                'location',
                'currentDateTime',
                'currentWeather',
                'currentWeatherDescription',
                'currentTemperature',
                'minTemperature',
                'maxTemperature',
                'pressure',
                'humidity',
                'visibility',
                'windSpeed',
                'windDegree',
                'sunrise',
                'sunset',
            ]);
    }

    /** @test */
    public function cantGetLocationData()
    {
        $this->getJson(route('place.weather', ['place' => $this->faker->words(3, true)]))
            ->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function missingPlaceParamater()
    {
        $this->getJson(route('place.weather'))
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
