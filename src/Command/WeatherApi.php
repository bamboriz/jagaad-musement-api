<?php
namespace App\Command;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class WeatherApi
{
    private $API_KEY;
    private $BASE_URL =  "http://api.weatherapi.com/v1";

    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
        $this->API_KEY = $_ENV['API_KEY'];
    }

    public function getCityForecast($lat, $lon)
    {
        $response = $this->client->request(
            'GET',
            $this->BASE_URL."/forecast.json?key={$this->API_KEY}&q={$lat},{$lon}&days=2"
        );
        return $response;
    }
}