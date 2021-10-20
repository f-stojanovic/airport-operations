<?php

namespace App\Service;

use App\Repository\AircraftRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

class AircraftService
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

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getParkingSpotsCountInfo($type)
    {
        return $this->aircraftRepository->getParkingSpotCount(
            $type,
            intval($this->airlinerParkingSpots),
            intval($this->privateParkingSpots)
        );
    }
}
