<?php

namespace App\Tests;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends WebTestCase
{

    public function testMusementCities()
    {
        // Simple test to verify that info on Musement API is up to date.
        $declaredMusementParkCities = 100;
        $client = static::createClient();
        $client->request('GET', '/api/v3/cities');
        
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $cities = json_decode($client->getResponse()->getContent());
        $this->assertEquals($declaredMusementParkCities, count($cities));
    }
}