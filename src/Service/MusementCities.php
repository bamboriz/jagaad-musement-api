<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class MusementCities
{
    protected $client;
    private $cities;
    private $api;

    public function __construct(HttpClientInterface $client, WeatherService $api)
    {
        $this->client = $client;
        $this->api = $api;
    }

    public function get(){
        $response = $this->client->request(
            'GET',
            'https://api.musement.com/api/v3/cities.json'
        );

        $this->cities = json_decode($response->getContent());
    }

    public function processCities(){

        foreach ($this->cities as $city) {

            $response = $this->api->getCityForecast($city->latitude, $city->longitude);
            $today = $response[0];
            $tomorrow = $response[1];

            $cityForecasts[] = array("city" => $city->name, "lat"=> $city->latitude, "lon"=> $city->longitude, "today"=> $today, "tomorrow"=>  $tomorrow);
            
        }
        return $cityForecasts;
    }
}


