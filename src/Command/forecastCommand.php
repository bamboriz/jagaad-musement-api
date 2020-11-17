<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\HttpClient\HttpClientInterface;



class forecastCommand extends Command
{
    protected static $defaultName = 'city:daily-forecasts';

    private $client;
    private $API_KEY;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
        $this->API_KEY = $_ENV['API_KEY'];
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('gets the list of the cities from Musement\'s API
            for each city gets the forecast for the next 2 days using http://api.weatherapi.com')
            //->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            //->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $cityForecasts = [];
        $count = 0;
        $cities = $this->getMusementCities();

        foreach ($cities as $city) {
            //if ($count > 30) break;

            $response = $this->client->request(
                'GET',
                "http://api.weatherapi.com/v1/forecast.json?key={$this->API_KEY}&q={$city->latitude},{$city->longitude}&days=2"
            );

            $forecastData = json_decode($response->getContent())->forecast->forecastday;
            $today = $forecastData[0]->day->condition->text;
            $tomorrow = $forecastData[1]->day->condition->text;

            $cityForecasts[] = array("city" => $city->name, "lat"=> $city->latitude, "lon"=> $city->longitude, "today"=> $today, "tomorrow"=>  $tomorrow);
            $count++;
            $output->writeln("Processed city {$city->name} | {$today} - {$tomorrow}");
            
        }

        $io->success($count.' cities processed');
        return Command::SUCCESS;
    }

    protected function getMusementCities()
    {
        $response = $this->client->request(
            'GET',
            'https://api.musement.com/api/v3/cities.json'
        );

        $cities = json_decode($response->getContent());
        return $cities;
    }
}
