<?php

namespace App\Command;

use App\Service\WeatherApiService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class WeatherCommand extends Command
{
    protected static $defaultName = 'weather:check';

    /**
     * @var WeatherApiService
     */
    private $weatherApiService;

    public function __construct(WeatherApiService $weatherApiService)
    {
        parent::__construct();
        $this->weatherApiService = $weatherApiService;
    }

    protected function configure()
    {
        $this
            ->setDescription('Requesting a weather change from WeatherAPI.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $ioStream = new SymfonyStyle($input, $output);
        $ioStream->title('CHECK WEATHER');
        try {
            $this->weatherApiService->getWeatherInformation();
        } catch (\Throwable $e) {
            $ioStream->error('Error occured: ' . $e->getMessage());

            return 1;
        }
        $ioStream->success('Execution completed.');

        return 0;
    }
}