<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Room
 *
 * @ORM\Table(name="room")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RoomRepository")
 */
class Room
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float|null
     *
     * @ORM\Column(name="backing", type="float", nullable=true)
     */
    private $backing;

    /**
     * @var int|null
     *
     * @ORM\Column(name="transparency", type="integer", nullable=true)
     */
    private $transparency;

    /**
     * @var float|null
     *
     * @ORM\Column(name="thermalTransmittance", type="float", nullable=true)
     */
    private $thermalTransmittance;

    /**
     * @var float|null
     *
     * @ORM\Column(name="width", type="float", nullable=true)
     */
    private $width;

    /**
     * @var float|null
     *
     * @ORM\Column(name="high", type="float", nullable=true)
     */
    private $high;

    /**
     * @var float|null
     *
     * @ORM\Column(name="lenght", type="float",nullable=true)
     */
    private $lenght;

    /**
     * @var float|null
     *
     * @ORM\Column(name="glazedSurface", type="float", nullable=true)
     */
    private $glazedSurface;

    /**
     * @var string|null
     *
     * @ORM\Column(name="floor", type="string", length=255, nullable=true)
     */
    private $floor;

    /**
     * @var string|null
     *
     * @ORM\Column(name="walls", type="string", length=255, nullable=true)
     */
    private $walls;

    /**
     * @var string|null
     *
     * @ORM\Column(name="windows", type="string", length=255, nullable=true)
     */
    private $windows;

    /**
     * @var string|null
     *
     * @ORM\Column(name="uses", type="string", length=255, nullable=true)
     */
    private $uses;

    /**
     * @var string|null
     *
     * @ORM\Column(name="conditionerEquipment", type="string", length=255, nullable=true)
     */
    private $conditionerEquipment;

    /**
     * @ORM\ManyToOne(targetEntity="Library", inversedBy="room")
     * @ORM\JoinColumn(name="library_id", referencedColumnName="id")
     */
    private $library;

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
     * Set backing.
     *
     * @param float|null $backing
     *
     * @return Room
     */
    public function setBacking($backing = null)
    {
        $this->backing = $backing;

        return $this;
    }

    /**
     * Get backing.
     *
     * @return float|null
     */
    public function getBacking()
    {
        return $this->backing;
    }

    /**
     * Set transparency.
     *
     * @param int|null $transparency
     *
     * @return Room
     */
    public function setTransparency($transparency = null)
    {
        $this->transparency = $transparency;

        return $this;
    }

    /**
     * Get transparency.
     *
     * @return int|null
     */
    public function getTransparency()
    {
        return $this->transparency;
    }

    /**
     * Set thermalTransmittance.
     *
     * @param float|null $thermalTransmittance
     *
     * @return Room
     */
    public function setThermalTransmittance($thermalTransmittance = null)
    {
        $this->thermalTransmittance = $thermalTransmittance;

        return $this;
    }

    /**
     * Get thermalTransmittance.
     *
     * @return float|null
     */
    public function getThermalTransmittance()
    {
        return $this->thermalTransmittance;
    }

    /**
     * Set width.
     *
     * @param float|null $width
     *
     * @return Room
     */
    public function setWidth($width = null)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width.
     *
     * @return float|null
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set high.
     *
     * @param float $high
     *
     * @return Room
     */
    public function setHigh($high)
    {
        $this->high = $high;

        return $this;
    }

    /**
     * Get high.
     *
     * @return float
     */
    public function getHigh()
    {
        return $this->high;
    }

    /**
     * Set lenght.
     *
     * @param float $lenght
     *
     * @return Room
     */
    public function setLenght($lenght)
    {
        $this->lenght = $lenght;

        return $this;
    }

    /**
     * Get lenght.
     *
     * @return float
     */
    public function getLenght()
    {
        return $this->lenght;
    }

    /**
     * Set glazedSurface.
     *
     * @param float|null $glazedSurface
     *
     * @return Room
     */
    public function setGlazedSurface($glazedSurface = null)
    {
        $this->glazedSurface = $glazedSurface;

        return $this;
    }

    /**
     * Get glazedSurface.
     *
     * @return float|null
     */
    public function getGlazedSurface()
    {
        return $this->glazedSurface;
    }

    /**
     * Set floor.
     *
     * @param string|null $floor
     *
     * @return Room
     */
    public function setFloor($floor = null)
    {
        $this->floor = $floor;

        return $this;
    }

    /**
     * Get floor.
     *
     * @return string|null
     */
    public function getFloor()
    {
        return $this->floor;
    }

    /**
     * Set walls.
     *
     * @param string|null $walls
     *
     * @return Room
     */
    public function setWalls($walls = null)
    {
        $this->walls = $walls;

        return $this;
    }

    /**
     * Get walls.
     *
     * @return string|null
     */
    public function getWalls()
    {
        return $this->walls;
    }

    /**
     * Set windows.
     *
     * @param string|null $windows
     *
     * @return Room
     */
    public function setWindows($windows = null)
    {
        $this->windows = $windows;

        return $this;
    }

    /**
     * Get windows.
     *
     * @return string|null
     */
    public function getWindows()
    {
        return $this->windows;
    }

    /**
     * Set uses.
     *
     * @param string|null $uses
     *
     * @return Room
     */
    public function setUses($uses = null)
    {
        $this->uses = $uses;

        return $this;
    }

    /**
     * Get uses.
     *
     * @return string|null
     */
    public function getUses()
    {
        return $this->uses;
    }

    /**
     * Set conditionerEquipment.
     *
     * @param string|null $conditionerEquipment
     *
     * @return Room
     */
    public function setConditionerEquipment($conditionerEquipment = null)
    {
        $this->conditionerEquipment = $conditionerEquipment;

        return $this;
    }

    /**
     * Get conditionerEquipment.
     *
     * @return string|null
     */
    public function getConditionerEquipment()
    {
        return $this->conditionerEquipment;
    }

    /**
     * Set library.
     *
     * @param \AppBundle\Entity\Library|null $library
     *
     * @return Room
     */
    public function setLibrary(\AppBundle\Entity\Library $library = null)
    {
        $this->library = $library;

        return $this;
    }

    /**
     * Get library.
     *
     * @return \AppBundle\Entity\Library|null
     */
    public function getLibrary()
    {
        return $this->library;
    }
}
