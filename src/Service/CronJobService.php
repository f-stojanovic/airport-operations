<?php

namespace App\Service;

use App\Entity\Aircraft;
use App\Entity\Logs;
use App\Repository\AircraftRepository;
use App\Repository\GroundCrewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class CronJobService
{
    /**
     * @var AircraftRepository
     */
    private $aircraftRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var LogsService
     */
    private $logsService;

    /**
     * @var GroundCrewRepository
     */
    private $groundCrewRepository;

    /**
     * ParkingService constructor.
     */
    public function __construct(
        AircraftRepository $aircraftRepository,
        EntityManagerInterface $entityManager,
        LogsService $logsService,
        GroundCrewRepository $groundCrewRepository
    ) {
        $this->aircraftRepository = $aircraftRepository;
        $this->entityManager = $entityManager;
        $this->logsService = $logsService;
        $this->groundCrewRepository = $groundCrewRepository;
    }

    /**
     * Cron job that is triggered every 3 minutes to check if any aircraft is on approach,
     * and if so, changing its status to LANDED.
     * @throws Exception
     */
    public function onApproachCheckAction()
    {
        $aircraft = $this->aircraftRepository->onApproachCheck();
        $groundCrew = $this->groundCrewRepository->getMainGroundCrew();

        if ($aircraft) {
            $aircraft->setPosition(Aircraft::POSITION_LANDED);
            $this->entityManager->persist($aircraft);
            $this->entityManager->flush();

            $this->logsService->setLogInfo(
                $aircraft->getName(),
                $aircraft,
                $groundCrew,
                Logs::STATE_ACCEPTED,
                $aircraft->getPosition()
            );
        }
    }

    /**
     * Cron job that is triggered every 1 minute to check if any aircraft is landed,
     * and if so, changing its status to PARKED.
     * @throws Exception
     */
    public function landedCheckAction()
    {
        $aircraft = $this->aircraftRepository->landedCheck();
        $groundCrew = $this->groundCrewRepository->getMainGroundCrew();

        if ($aircraft) {
            $aircraft->setPosition(Aircraft::POSITION_PARKED);
            $this->entityManager->persist($aircraft);
            $this->entityManager->flush();

            $this->logsService->setLogInfo(
                $aircraft->getName(),
                $aircraft,
                $groundCrew,
                Logs::STATE_ACCEPTED,
                $aircraft->getPosition()
            );
        }
    }
}
