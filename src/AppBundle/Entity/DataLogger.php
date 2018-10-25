<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DataLogger
 *
 * @ORM\Table(name="data_logger")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DataLoggerRepository")
 */
class DataLogger
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer" , nullable=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int|null
     *
     * @ORM\Column(name="number", type="integer" , nullable=true)
     */
    private $number;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var int|null
     *
     * @ORM\Column(name="temperature", type="integer" , nullable=true)
     */
    private $temperature;

    /**
     * @var int|null
     *
     * @ORM\Column(name="rh", type="integer" , nullable=true)
     */
    private $rh;

    /**
     * @var int|null
     *
     * @ORM\Column(name="dewpt", type="integer" , nullable=true)
     */
    private $dewpt;

    /**
     * @ORM\ManyToOne(targetEntity="Room", inversedBy="dataLoggers")
     * @ORM\JoinColumn(name="room_id", referencedColumnName="id")
     */
    private $room;




    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set number.
     *
     * @param int|null $number
     *
     * @return DataLogger
     */
    public function setNumber($number = null)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number.
     *
     * @return int|null
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return DataLogger
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set time.
     *
     * @param \DateTime $time
     *
     * @return DataLogger
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time.
     *
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set temperature.
     *
     * @param int $temperature
     *
     * @return DataLogger
     */
    public function setTemperature($temperature)
    {
        $this->temperature = $temperature;

        return $this;
    }

    /**
     * Get temperature.
     *
     * @return integer
     */
    public function getTemperature()
    {
        return $this->temperature;
    }

    /**
     * Set rh.
     *
     * @param int $rh
     *
     * @return DataLogger
     */
    public function setRh($rh)
    {
        $this->rh = $rh;

        return $this;
    }

    /**
     * Get rh.
     *
     * @return integer
     */
    public function getRh()
    {
        return $this->rh;
    }

    /**
     * Set dewpt.
     *
     * @param int $dewpt
     *
     * @return DataLogger
     */
    public function setDewpt($dewpt)
    {
        $this->dewpt = $dewpt;

        return $this;
    }

    /**
     * Get dewpt.
     *
     * @return integer
     */
    public function getDewpt()
    {
        return $this->dewpt;
    }

    /**
     * Set room.
     *
     * @param \AppBundle\Entity\Room|null $room
     *
     * @return DataLogger
     */
    public function setRoom(\AppBundle\Entity\Room $room = null)
    {
        $this->room = $room;

        return $this;
    }

    /**
     * Get room.
     *
     * @return \AppBundle\Entity\Room|null
     */
    public function getRoom()
    {
        return $this->room;
    }
}
