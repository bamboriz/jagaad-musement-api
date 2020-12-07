<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class WeatherApi implements WeatherService
{
    private $WeatherAPI_KEY;
    private $BASE_URL =  "http://api.weatherapi.com/v1";

    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
        $this->WeatherAPI_KEY = $_ENV['API_KEY'];
    }

    public function getCityForecast($lat, $lon): array
    {
        $response = $this->client->request(
            'GET',
            $this->BASE_URL."/forecast.json?key={$this->WeatherAPI_KEY}&q={$lat},{$lon}&days=2"
        );
   
        $forecastData = json_decode($response->getContent())->forecast->forecastday;
        $today = $forecastData[0]->day->condition->text;
        $tomorrow = $forecastData[1]->day->condition->text;
        return [$today, $tomorrow];
    }
}