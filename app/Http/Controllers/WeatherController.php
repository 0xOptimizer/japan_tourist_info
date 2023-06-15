<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WeatherService;
use App\Services\VenueService;
use App\Services\WeatherAnalysisService;

class WeatherController extends Controller
{
    private $weatherService;
    private $venueService;
    private $weatherAnalysisService;

    public function __construct(
        WeatherService $weatherService,
        VenueService $venueService,
        WeatherAnalysisService $weatherAnalysisService
    ) {
        $this->weatherService = $weatherService;
        $this->venueService = $venueService;
        $this->weatherAnalysisService = $weatherAnalysisService;
    }

    private function getDataForCity($city)
    {
        $data = ['city' => $city];
        $weatherData = $this->weatherService->getWeatherData($city);

        if (!empty($weatherData)) {
            $data['weather'] = $weatherData;
            $data['venues'] = $this->venueService->getVenueData($city);
            $data['weather_analysis'] = $this->weatherAnalysisService->getWeatherAnalysis($weatherData);
        }

        return $data;
    }

    public function show($city = null)
    {
        $data = [];

        if ($city !== null) {
            $data = $this->getDataForCity($city);
            $data['city'] = $city;
        }

        $data['cities'] = [
            'tokyo' => 'Tokyo',
            'yokohama' => 'Yokohama',
            'osaka' => 'Osaka',
            'sapporo' => 'Sapporo',
            'nagoya' => 'Nagoya',
        ];

        return view('weather', $data);
    }
}