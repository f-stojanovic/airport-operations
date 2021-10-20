<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Exception;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WeatherRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Weather
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $description;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $temperature;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $visibility;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $windSpeed;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $windDag;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastUpdate;

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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getTemperature()
    {
        return $this->temperature;
    }

    /**
     * @param mixed $temperature
     */
    public function setTemperature($temperature): void
    {
        $this->temperature = $temperature;
    }

    /**
     * @return mixed
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * @param mixed $visibility
     */
    public function setVisibility($visibility): void
    {
        $this->visibility = $visibility;
    }

    /**
     * @return mixed
     */
    public function getWindSpeed()
    {
        return $this->windSpeed;
    }

    /**
     * @param mixed $windSpeed
     */
    public function setWindSpeed($windSpeed): void
    {
        $this->windSpeed = $windSpeed;
    }

    /**
     * @return mixed
     */
    public function getWindDag()
    {
        return $this->windDag;
    }

    /**
     * @param mixed $windDag
     */
    public function setWindDag($windDag): void
    {
        $this->windDag = $windDag;
    }

    /**
     * @return mixed
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }

    /**
     * @ORM\PreUpdate
     *
     * @throws Exception
     */
    public function setLastUpdate(): Weather
    {
        $date = new DateTime();
        $this->lastUpdate = $date->getTimestamp();

        return $this;
    }
}
