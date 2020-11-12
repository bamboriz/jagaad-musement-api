<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class ForecastController extends AbstractController
{

    /**
     * @Route("/")
     */
    public function getCityForecast()
    {
        return new Response("<h2>Nice to meet you! 😇</h2>");
    }
}
