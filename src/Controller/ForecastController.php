<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class ForecastController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @Route("/")
     */
    public function getCityForecast()
    {
        return new Response("<h2>Nice to meet you! 😇</h2>");
    }

    /**
     * @Route("/api/v3/cities")
     */
    public function getMusementCities()
    {
        $response = $this->client->request(
            'GET',
            'https://api.musement.com/api/v3/cities.json'
        );
        //$cities = new JsonResponse($response->getContent());
        return new Response($response->getContent());
    }
}
