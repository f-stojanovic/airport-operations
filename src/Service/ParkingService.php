<?php

namespace App\Service;

use App\Repository\AircraftRepository;

class ParkingService
{
    private $airlinerParkingSpots;
    private $privateParkingSpots;

    /**
     * @var AircraftRepository
     */
    private $aircraftRepository;

    /**
     * ParkingService constructor.
     */
    public function __construct(
        string $airlinerParkingSpots,
        string $privateParkingSpots,
        AircraftRepository $aircraftRepository
    ) {
        $this->airlinerParkingSpots = $airlinerParkingSpots;
        $this->privateParkingSpots = $privateParkingSpots;
        $this->aircraftRepository = $aircraftRepository;
    }

    public function parkingSpotInfo(): array
    {
        $location = 'Belgrade';
        $runway = 1;

        $countAirliner = $this->aircraftRepository->airlinerParkedCount();
        $countPrivate = $this->aircraftRepository->privateParkedCount();
        $parkedAirliner = $this->aircraftRepository->getParkedAirliner();
        $parkedPrivate = $this->aircraftRepository->getParkedPrivate();

        return [
            'location' => $location,
            'runway' => $runway,
            'airliner' => $this->airlinerParkingSpots - $countAirliner,
            'private' => $this->privateParkingSpots - $countPrivate,
            'parkedAirliner' => $parkedAirliner,
            'parkedPrivate' => $parkedPrivate,
        ];
    }
}
