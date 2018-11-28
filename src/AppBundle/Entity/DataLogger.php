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
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var decimal|null
     *
     * @ORM\Column(name="mean_av_H", type="decimal" , nullable=true)
     */
    private $meanAvH;

    /**
     * @var decimal|null
     *
     * @ORM\Column(name="mean_av_T", type="decimal" , nullable=true)
     */
    private $meanAvT;

    /**
     * @var decimal|null
     *
     * @ORM\Column(name="reg_mean_av_H", type="decimal" , nullable=true)
     */
    private $regMeanAvH;

    /**
     * @var decimal|null
     *
     * @ORM\Column(name="reg_mean_av_T", type="decimal" , nullable=true)
     */
    private $regMeanAvT;


    /**
     * @var decimal|null
     *
     * @ORM\Column(name="botton_limit_H", type="decimal" , nullable=true)
     */
    private $bottonLimitH;

    /**
     * @var decimal|null
     *
     * @ORM\Column(name="botton_limit_T", type="decimal" , nullable=true)
     */
    private $bottonLimitT;

    /**
     * @var decimal|null
     *
     * @ORM\Column(name="top_limit_H", type="decimal" , nullable=true)
     */
    private $topLimitH;

    /**
     * @var decimal|null
     *
     * @ORM\Column(name="top_limit_T", type="decimal" , nullable=true)
     */
    private $topLimitT;

    /**
     * @var decimal|null
     *
     * @ORM\Column(name="temperature", type="decimal" , nullable=true)
     */
    private $temperature;

    /**
     * @var decimal|null
     *
     * @ORM\Column(name="rh", type="decimal" , nullable=true)
     */
    private $rh;

    /**
     * @var decimal|null
     *
     * @ORM\Column(name="dewpt", type="decimal" , nullable=true)
     */
    private $dewpt;
    
    /**
     * @var string
     *
     * @ORM\Column(name="unique_attr", type="decimal" , nullable=false, unique=true)
     */
    private $uniqueAttr;

    /**
     * @ORM\ManyToOne(targetEntity="Room", inversedBy="dataLoggers")
     * @ORM\JoinColumn(name="room_id", referencedColumnName="id")
     */
    private $room;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

    public function __construct($date, $room)
    {
<<<<<<< HEAD
        $this->date=$date;
        $this->room=$room;
        $this->uniqueAttr=$this->generateUniqueAttr($date,$room);
        $this->enabled=true;
=======
        $this->enabled=false;
>>>>>>> 39bf39f3b120e24d6f381f4e2537d0b844d7abd9
    }

    /**
     * @return string
     */
    private function generateUniqueAttr($date, $room)
    {
        $uniqid=str_replace("\r",'',$date);
        $uniqid=$uniqid.$room->getId();
        return md5($uniqid);
    }


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

    /**
     * Set enabled.
     *
     * @param bool $enabled
     *
     * @return DataLogger
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled.
     *
     * @return bool
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set meanAvH.
     *
     * @param \decimal|null $meanAvH
     *
     * @return DataLogger
     */
    public function setMeanAvH(\decimal $meanAvH = null)
    {
        $this->meanAvH = $meanAvH;

        return $this;
    }

    /**
     * Get meanAvH.
     *
     * @return \decimal|null
     */
    public function getMeanAvH()
    {
        return $this->meanAvH;
    }

    /**
     * Set meanAvT.
     *
     * @param \decimal|null $meanAvT
     *
     * @return DataLogger
     */
    public function setMeanAvT(\decimal $meanAvT = null)
    {
        $this->meanAvT = $meanAvT;

        return $this;
    }

    /**
     * Get meanAvT.
     *
     * @return \decimal|null
     */
    public function getMeanAvT()
    {
        return $this->meanAvT;
    }

    /**
     * Set regMeanAvH.
     *
     * @param \decimal|null $regMeanAvH
     *
     * @return DataLogger
     */
    public function setRegMeanAvH(\decimal $regMeanAvH = null)
    {
        $this->regMeanAvH = $regMeanAvH;

        return $this;
    }

    /**
     * Get regMeanAvH.
     *
     * @return \decimal|null
     */
    public function getRegMeanAvH()
    {
        return $this->regMeanAvH;
    }

    /**
     * Set regMeanAvT.
     *
     * @param \decimal|null $regMeanAvT
     *
     * @return DataLogger
     */
    public function setRegMeanAvT(\decimal $regMeanAvT = null)
    {
        $this->regMeanAvT = $regMeanAvT;

        return $this;
    }

    /**
     * Get regMeanAvT.
     *
     * @return \decimal|null
     */
    public function getRegMeanAvT()
    {
        return $this->regMeanAvT;
    }

    /**
     * Set bottonLimitH.
     *
     * @param \decimal|null $bottonLimitH
     *
     * @return DataLogger
     */
    public function setBottonLimitH(\decimal $bottonLimitH = null)
    {
        $this->bottonLimitH = $bottonLimitH;

        return $this;
    }

    /**
     * Get bottonLimitH.
     *
     * @return \decimal|null
     */
    public function getBottonLimitH()
    {
        return $this->bottonLimitH;
    }

    /**
     * Set bottonLimitT.
     *
     * @param \decimal|null $bottonLimitT
     *
     * @return DataLogger
     */
    public function setBottonLimitT(\decimal $bottonLimitT = null)
    {
        $this->bottonLimitT = $bottonLimitT;

        return $this;
    }

    /**
     * Get bottonLimitT.
     *
     * @return \decimal|null
     */
    public function getBottonLimitT()
    {
        return $this->bottonLimitT;
    }

    /**
     * Set topLimitH.
     *
     * @param \decimal|null $topLimitH
     *
     * @return DataLogger
     */
    public function setTopLimitH(\decimal $topLimitH = null)
    {
        $this->topLimitH = $topLimitH;

        return $this;
    }

    /**
     * Get topLimitH.
     *
     * @return \decimal|null
     */
    public function getTopLimitH()
    {
        return $this->topLimitH;
    }

    /**
     * Set topLimitT.
     *
     * @param \decimal|null $topLimitT
     *
     * @return DataLogger
     */
    public function setTopLimitT(\decimal $topLimitT = null)
    {
        $this->topLimitT = $topLimitT;

        return $this;
    }

    /**
     * Get topLimitT.
     *
     * @return \decimal|null
     */
    public function getTopLimitT()
    {
        return $this->topLimitT;
    }
}
