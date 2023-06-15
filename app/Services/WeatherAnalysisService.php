<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherAnalysisService
{
    public function getWeatherAnalysis($data)
    {
        // Wrap the JSON string in another JSON object with 'prompt' as the key
        $json = json_encode(['prompt' => $data]);

        // Get weather analysis guide from the AI
        $response = Http::withBody($json, 'application/json')->post("http://labs.tewi.club/api/v1/weather");

        return $response->json();
    }
}