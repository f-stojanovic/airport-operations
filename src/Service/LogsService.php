<?php

namespace App\Service;

use App\Entity\Logs;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class LogsService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * LogsService constructor.
     */
    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    /**
     * @throws Exception
     */
    public function setLogInfo($name, $aircraft, $groundCrew, $state, $position)
    {
        $newLog = new Logs();
        $newLog->setName($name);
        $newLog->setAircraft($aircraft);
        $newLog->setGroundCrew($groundCrew);
        $newLog->setState($state);
        $newLog->setPosition($position);
        $newLog->setTimeOfChange();

        $this->entityManager->persist($newLog);
        $this->entityManager->flush();
    }
}
