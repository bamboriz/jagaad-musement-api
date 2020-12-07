<?php

namespace App\Service;

interface WeatherService
{   
    public function getCityForecast($lat, $lon): array;
}