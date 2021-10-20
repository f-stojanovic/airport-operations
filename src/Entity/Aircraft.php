<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AircraftRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Aircraft
{
    const TYPE_AIRLINER = 'airliner';
    const TYPE_PRIVATE = 'private';

    const POSITION_PARKED = 'parked';
    const POSITION_TAKE_OFF = 'take_off';
    const POSITION_AIRBORNE = 'airborne';
    const POSITION_APPROACH = 'approach';
    const POSITION_LANDED = 'landed';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\Choice(
     *     choices={
     *      Aircraft::TYPE_AIRLINER,
     *      Aircraft::TYPE_PRIVATE
     *      }, message="API.VALIDATION_ERROR.INVALID_TYPE_AIRCRAFT", strict=true)
     */
    private $type;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\Choice(
     *     choices={
     *      Aircraft::POSITION_PARKED,
     *      Aircraft::POSITION_TAKE_OFF,
     *      Aircraft::POSITION_AIRBORNE,
     *      Aircraft::POSITION_APPROACH,
     *      Aircraft::POSITION_LANDED
     *      }, message="API.VALIDATION_ERROR.INVALID_AIRCRAFT_POSITION", strict=true)
     */
    private $position;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $callSign;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $latitude;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $longitude;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $altitude;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $heading;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): Aircraft
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): Aircraft
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position): Aircraft
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCallSign()
    {
        return $this->callSign;
    }

    /**
     * @param mixed $callSign
     */
    public function setCallSign($callSign): Aircraft
    {
        $this->callSign = $callSign;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude): Aircraft
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude): Aircraft
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAltitude()
    {
        return $this->altitude;
    }

    /**
     * @param mixed $altitude
     */
    public function setAltitude($altitude): Aircraft
    {
        $this->altitude = $altitude;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHeading()
    {
        return $this->heading;
    }

    /**
     * @param mixed $heading
     */
    public function setHeading($heading): Aircraft
    {
        $this->heading = $heading;

        return $this;
    }
}
