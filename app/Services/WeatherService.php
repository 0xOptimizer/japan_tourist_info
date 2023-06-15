<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    public function getWeatherData($city)
    {
        // Get weather data from OpenWeatherMap
        $response = Http::get("http://api.openweathermap.org/data/2.5/weather?q={$city},jp&appid=" . env('OPEN_WEATHER_MAP_API_KEY'));

        return $response->json();
    }
}