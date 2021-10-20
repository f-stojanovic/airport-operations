<?php

namespace App\DataFixtures;

use App\Entity\Aircraft;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * AircraftFixtures.
 */
class AircraftFixtures extends Fixture
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

        $this->manager->persist($this->persistAircraftOne());
        $this->manager->persist($this->persistAircraftTwo());
        $this->manager->persist($this->persistAircraftThree());
        $this->manager->persist($this->persistAircraftFour());
        $this->manager->persist($this->persistAircraftFive());
        $this->manager->persist($this->persistAircraftSix());
        $this->manager->persist($this->persistAircraftSeven());
        $this->manager->persist($this->persistAircraftEight());
        $this->manager->persist($this->persistAircraftNine());
        $this->manager->persist($this->persistAircraftTen());
        $this->manager->persist($this->persistAircraftEleven());
        $this->manager->persist($this->persistAircraftTwelve());
        $this->manager->persist($this->persistAircraftThirteen());
        $this->manager->persist($this->persistAircraftFourteen());
        $this->manager->persist($this->persistAircraftFifteen());

        $this->manager->flush();
    }

    private function persistAircraftOne(): Aircraft
    {
        $aircraft = new Aircraft();
        $aircraft
            ->setName('Aircraft One')
            ->setType(Aircraft::TYPE_AIRLINER)
            ->setPosition(Aircraft::POSITION_LANDED)
            ->setCallSign('NC9574')
            ->setLatitude('44.82128505247063')
            ->setLongitude('20.455516172478386')
            ->setAltitude(3500)
            ->setHeading(220)
        ;

        return $aircraft;
    }

    private function persistAircraftTwo(): Aircraft
    {
        $aircraft = new Aircraft();
        $aircraft
            ->setName('Aircraft Two')
            ->setType(Aircraft::TYPE_AIRLINER)
            ->setPosition(Aircraft::POSITION_PARKED)
            ->setCallSign('NC2571')
            ->setLatitude(null)
            ->setLongitude(null)
            ->setAltitude(null)
            ->setHeading(null)
        ;

        return $aircraft;
    }

    private function persistAircraftThree(): Aircraft
    {
        $aircraft = new Aircraft();
        $aircraft
            ->setName('Aircraft Three')
            ->setType(Aircraft::TYPE_AIRLINER)
            ->setPosition(Aircraft::POSITION_PARKED)
            ->setCallSign('NC7774')
            ->setLatitude(null)
            ->setLongitude(null)
            ->setAltitude(null)
            ->setHeading(null)
        ;

        return $aircraft;
    }

    private function persistAircraftFour(): Aircraft
    {
        $aircraft = new Aircraft();
        $aircraft
            ->setName('Aircraft Four')
            ->setType(Aircraft::TYPE_AIRLINER)
            ->setPosition(Aircraft::POSITION_PARKED)
            ->setCallSign('NC4374')
            ->setLatitude(null)
            ->setLongitude(null)
            ->setAltitude(null)
            ->setHeading(null)
        ;

        return $aircraft;
    }

    private function persistAircraftFive(): Aircraft
    {
        $aircraft = new Aircraft();
        $aircraft
            ->setName('Aircraft Five')
            ->setType(Aircraft::TYPE_AIRLINER)
            ->setPosition(Aircraft::POSITION_PARKED)
            ->setCallSign('NC1574')
            ->setLatitude(null)
            ->setLongitude(null)
            ->setAltitude(null)
            ->setHeading(null)
        ;

        return $aircraft;
    }

    private function persistAircraftSix(): Aircraft
    {
        $aircraft = new Aircraft();
        $aircraft
            ->setName('Aircraft Six')
            ->setType(Aircraft::TYPE_PRIVATE)
            ->setPosition(Aircraft::POSITION_APPROACH)
            ->setCallSign('NC1333')
            ->setLatitude('44.82128505247063')
            ->setLongitude('20.455516172478386')
            ->setAltitude(3500)
            ->setHeading(220)
        ;

        return $aircraft;
    }

    private function persistAircraftSeven(): Aircraft
    {
        $aircraft = new Aircraft();
        $aircraft
            ->setName('Aircraft Seven')
            ->setType(Aircraft::TYPE_PRIVATE)
            ->setPosition(Aircraft::POSITION_PARKED)
            ->setCallSign('NC9463')
            ->setLatitude(null)
            ->setLongitude(null)
            ->setAltitude(null)
            ->setHeading(null)
        ;

        return $aircraft;
    }

    private function persistAircraftEight(): Aircraft
    {
        $aircraft = new Aircraft();
        $aircraft
            ->setName('Aircraft Eight')
            ->setType(Aircraft::TYPE_PRIVATE)
            ->setPosition(Aircraft::POSITION_PARKED)
            ->setCallSign('NC3974')
            ->setLatitude(null)
            ->setLongitude(null)
            ->setAltitude(null)
            ->setHeading(null)
        ;

        return $aircraft;
    }

    private function persistAircraftNine(): Aircraft
    {
        $aircraft = new Aircraft();
        $aircraft
            ->setName('Aircraft Nine')
            ->setType(Aircraft::TYPE_PRIVATE)
            ->setPosition(Aircraft::POSITION_PARKED)
            ->setCallSign('NC8741')
            ->setLatitude(null)
            ->setLongitude(null)
            ->setAltitude(null)
            ->setHeading(null)
        ;

        return $aircraft;
    }

    private function persistAircraftTen(): Aircraft
    {
        $aircraft = new Aircraft();
        $aircraft
            ->setName('Aircraft Ten')
            ->setType(Aircraft::TYPE_PRIVATE)
            ->setPosition(Aircraft::POSITION_PARKED)
            ->setCallSign('NC9348')
            ->setLatitude(null)
            ->setLongitude(null)
            ->setAltitude(null)
            ->setHeading(null)
        ;

        return $aircraft;
    }

    private function persistAircraftEleven(): Aircraft
    {
        $aircraft = new Aircraft();
        $aircraft
            ->setName('Aircraft Eleven')
            ->setType(Aircraft::TYPE_PRIVATE)
            ->setPosition(Aircraft::POSITION_PARKED)
            ->setCallSign('NC7741')
            ->setLatitude(null)
            ->setLongitude(null)
            ->setAltitude(null)
            ->setHeading(null)
        ;

        return $aircraft;
    }

    private function persistAircraftTwelve(): Aircraft
    {
        $aircraft = new Aircraft();
        $aircraft
            ->setName('Aircraft Twelve')
            ->setType(Aircraft::TYPE_PRIVATE)
            ->setPosition(Aircraft::POSITION_PARKED)
            ->setCallSign('NC2775')
            ->setLatitude(null)
            ->setLongitude(null)
            ->setAltitude(null)
            ->setHeading(null)
        ;

        return $aircraft;
    }

    private function persistAircraftThirteen(): Aircraft
    {
        $aircraft = new Aircraft();
        $aircraft
            ->setName('Aircraft Thirteen')
            ->setType(Aircraft::TYPE_PRIVATE)
            ->setPosition(Aircraft::POSITION_PARKED)
            ->setCallSign('NC6482')
            ->setLatitude(null)
            ->setLongitude(null)
            ->setAltitude(null)
            ->setHeading(null)
        ;

        return $aircraft;
    }

    private function persistAircraftFourteen(): Aircraft
    {
        $aircraft = new Aircraft();
        $aircraft
            ->setName('Aircraft Fourteen')
            ->setType(Aircraft::TYPE_PRIVATE)
            ->setPosition(Aircraft::POSITION_PARKED)
            ->setCallSign('NC4477')
            ->setLatitude(null)
            ->setLongitude(null)
            ->setAltitude(null)
            ->setHeading(null)
        ;

        return $aircraft;
    }

    private function persistAircraftFifteen(): Aircraft
    {
        $aircraft = new Aircraft();
        $aircraft
            ->setName('Aircraft Fifteen')
            ->setType(Aircraft::TYPE_PRIVATE)
            ->setPosition(Aircraft::POSITION_PARKED)
            ->setCallSign('NC3525')
            ->setLatitude(null)
            ->setLongitude(null)
            ->setAltitude(null)
            ->setHeading(null)
        ;

        return $aircraft;
    }
}
