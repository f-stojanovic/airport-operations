<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LogsRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Logs
{
    const STATE_ACCEPTED = 'accepted';
    const STATE_REJECTED = 'rejected';

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Aircraft")
     * @ORM\JoinColumn(name="aircraft", referencedColumnName="id", nullable=true)
     */
    protected $aircraft;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\GroundCrew")
     * @ORM\JoinColumn(name="ground_crew", referencedColumnName="id", nullable=true)
     */
    protected $groundCrew;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $state;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $position;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $timeOfChange;

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
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getAircraft()
    {
        return $this->aircraft;
    }

    /**
     * @param mixed $aircraft
     */
    public function setAircraft($aircraft): void
    {
        $this->aircraft = $aircraft;
    }

    /**
     * @return mixed
     */
    public function getGroundCrew()
    {
        return $this->groundCrew;
    }

    /**
     * @param mixed $groundCrew
     */
    public function setGroundCrew($groundCrew): void
    {
        $this->groundCrew = $groundCrew;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state): void
    {
        $this->state = $state;
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
    public function setPosition($position): void
    {
        $this->position = $position;
    }

    /**
     * @return mixed
     */
    public function getTimeOfChange()
    {
        return $this->timeOfChange;
    }

    /**
     * @ORM\PreUpdate
     *
     * @throws Exception
     */
    public function setTimeOfChange(): Logs
    {
        $date = new DateTime();
        $this->timeOfChange = $date->getTimestamp();

        return $this;
    }
}
