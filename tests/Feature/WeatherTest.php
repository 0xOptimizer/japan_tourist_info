<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WeatherTest extends TestCase
{
    /**
     * Tests weather page routing.
     *
     * @return void
     */
    public function test_weather_page_loads_correctly()
    {
        $response = $this->get('/weather/Tokyo');

        $response->assertStatus(200);
    }
}