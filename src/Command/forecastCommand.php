<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\HttpClient\HttpClientInterface;

use App\Service\MusementCities;

class forecastCommand extends Command
{
    protected static $defaultName = 'city:daily-forecasts';

    private $musementCities;

    public function __construct(MusementCities $musementCities)
    {
        $this->musementCities = $musementCities;
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
        $this->musementCities->get();
        $cityForecasts = $this->musementCities->processCities();
        $prints = $this->displayForecasts($cityForecasts, $output);

        $io->success($prints.' cities processed');
        return Command::SUCCESS;
    }

    private function displayForecasts(array $cityForecasts, OutputInterface $output):int
    {
        foreach ($cityForecasts as $forecast) {
            $output->writeln("Processed city {$forecast['city']} | {$forecast['today']} - {$forecast['tomorrow']}");
        }
        return count($cityForecasts);
    }

}

