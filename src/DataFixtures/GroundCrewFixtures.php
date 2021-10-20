<?php

namespace App\DataFixtures;

use App\Entity\GroundCrew;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * GroundCrewFixtures.
 */
class GroundCrewFixtures extends Fixture
{
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        $this->manager->persist($this->persistGroundCrew());

        $this->manager->flush();
    }

    private function persistGroundCrew(): GroundCrew
    {
        $groundCrew = new GroundCrew();
        $groundCrew
            ->setName('Main Ground Crew')
        ;

        return $groundCrew;
    }
}