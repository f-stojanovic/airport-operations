<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\LogsRepository;
use App\Repository\WeatherRepository;
use App\Service\MenuBuilder;
use App\Service\ParkingService;
use App\Traits\EntityManagerTrait;
use App\Traits\TwigTrait;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController
{
    use EntityManagerTrait;
    use TwigTrait;

    /**
     * @var MenuBuilder
     */
    private $builder;

    /**
     * @var LogsRepository
     */
    private $logsRepository;

    /**
     * @var ParkingService
     */
    private $parkingService;

    /**
     * @var WeatherRepository
     */
    private $weatherRepository;

    /**
     * DashboardController constructor.
     */
    public function __construct(
        MenuBuilder $builder,
        LogsRepository $logsRepository,
        ParkingService $parkingService,
        WeatherRepository $weatherRepository
    ) {
        $this->builder = $builder;
        $this->logsRepository = $logsRepository;
        $this->parkingService = $parkingService;
        $this->weatherRepository = $weatherRepository;
    }

    /**
     * @Route("/dashboard", methods={"GET"}, name="dashboard")
     */
    public function dashboardAction(): Response
    {
        $menu = $this->builder->getMenuData();
        $logs = $this->logsRepository->getLogsForDashboard();
        $parkingInfo = $this->parkingService->parkingSpotInfo();
        $weatherInfo = $this->weatherRepository->getWeatherInfo();

        return new Response($this->twig->render('index.html.twig', [
            'menu' => $menu,
            'logs' => $logs,
            'parkingInfo' => $parkingInfo,
            'weatherInfo' => $weatherInfo,
        ]));
    }
}
