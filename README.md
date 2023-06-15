# Japan Tourist Info

This project is a simple Laravel 8 app, created within 24 hours as part of a job application challenge. The application connects with APIs from OpenWeather, FourSquare, and a custom-made OpenAI API handler to provide a front-end service that delivers real-time weather data and venue information for several cities in Japan.

## Key Features

- API integration with OpenWeather, FourSquare, and custom OpenAI handler
- Encapsulation of API controllers into services for scalability
- Responsive and modern front-end using Bootstrap 5
- Single page application with error handlers
- Styling based on the modern "Glassmorphism" trend, utilizing a basic color palette derived from color theory

## Tech Stack
The design and architecture of this application have been carefully thought out to ensure a clean, scalable structure, for use in future continuation of the project.

### Backend
Laravel 8 serves as the backbone of this application, with a design philosophy that heavily leans towards compartmentalization. The logic for different API handlers has been encapsulated into distinct services, promoting scalability and ease of modification.

Consider the WeatherController, where dependency injection is employed to include services such as WeatherService, VenueService, and WeatherAnalysisService. Each service corresponds to a different API handler, with a design that fetches specific data pertinent to its domain. This setup not only simplifies the code in the controller but also supports the single responsibility principle, ensuring each service takes care of a specific task.

```php
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
}
```

One of the key highlights in this project is the use of a custom-built API that interacts with OpenAI to provide weather analysis. The WeatherAnalysisService sends the data received from the OpenWeather API to this custom API, which returns an AI-generated analysis of the weather. This not only showcases the application's ability to interact with multiple APIs but also highlights the innovative use of AI in the project.

```php
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
```

This approach of compartmentalizing functionality into separate services, combined with Laravel's dependency injection, greatly improves the project's readability and maintainability, facilitating a quick onboarding process for any developer.

### Frontend
The front-end leverages Bootstrap 5, bundled with jQuery, to ensure out-of-the-box responsiveness. With Bootstrap's vast selection of easily customizable components, it allows for rapid development without compromising on design or user experience.

The styling is also based on a design trend called "Glassmorphism" to create a modern feel despite being a simple application.

I've also implemented layouts (resources/views/layouts) using Laravel's Blade engine so that repetition is cut and allows a more streamline process for future development.

### Forced Limitations

In accordance to the requirements, the selection box for the cities are locked into just 5:

(app/Http/Controllers/WeatherController.php)
```php
$data['cities'] = [
    'tokyo' => 'Tokyo',
    'yokohama' => 'Yokohama',
    'osaka' => 'Osaka',
    'sapporo' => 'Sapporo',
    'nagoya' => 'Nagoya',
];
```

However the system could actually be forced to not follow this limitation and accomodate all Japanese cities and places as provided in the `VenueService` and `WeatherService` services (app/Services). To lift this, remove the "JP" tag in both of them. The number of venues could also be modified from the default 12 to a number that you wish that complies with FourSquare's API.

### General

In the development of this application, I aimed to adhere to the best practices and standards for all utilized languages: PHP, HTML5, CSS3, and JavaScript. While some speed-optimized decisions, like occasional inline styling, were necessary, I endeavored to keep the code clean, readable, and maintainable. This approach allows other developers an easy path to understand, contribute to, and deploy the project.

## Getting Started

Before getting started, you'll need to have PHP 7.4 or higher installed on your machine. Laravel 8 also requires Composer to manage dependencies.

Follow these steps to get the project running:

1. Install Composer. You can download it [here](https://getcomposer.org/download/).
2. Clone this repository to your local machine using `git clone https://github.com/0xOptimizer/japan_tourist_info`.
3. Navigate to the project directory in your terminal.
4. Run `composer install` to install the project dependencies.
5. Register for API keys from [OpenWeatherMap](https://home.openweathermap.org/users/sign_up) and [FourSquare](https://foursquare.com/developers/signup), and add these to your .env file:
```
OPEN_WEATHER_MAP_API_KEY=[Your OpenWeatherMap API key]
FOURSQUARE_API_KEY=[Your FourSquare API key]
```
6. Start the local development server by running `php artisan serve`.
7. Visit http://localhost:8000 in your browser to access the application.

Please note that this project doesn't require a database connection. You also don't need an API key for the AI analysis as it is hosted on my own Linux server.

You can also access the live version of the application here: https://mochi.tewi.club/location/.
