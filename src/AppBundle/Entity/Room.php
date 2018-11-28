<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @var string|null
     * @Assert\NotBlank()
     * @ORM\Column(name="b_use", type="string", nullable=false)
     */
    private $use;

    /**
     * @var string|"0"
     *
     * @ORM\Column(name="backing", type="float", nullable=true)
     */
    private $backing;

    /**
     * @var string|null
     *
     * @ORM\Column(name="b_transparency", type="float", nullable=true)
     */
    private $transparency;

    /**
     * @var string|"0"
     *
     * @ORM\Column(name="b_thermal_transmittance", type="float", nullable=true)
     */
    private $thermalTransmittance;

    /**
     * @var string|"0"
     *
     * @ORM\Column(name="b_dough", type="float", nullable=false)
     */
    private $dough;

    /**
     * @var string|"0"
     *
     * @ORM\Column(name="perc_7_h", type="float", nullable=true)
     */
    private $perc7H;

    /**
     * @var string|"0"
     *
     * @ORM\Column(name="perc_93_h", type="float", nullable=true)
     */
    private $perc93H;

    /**
     * @var string|"0"
     *
     * @ORM\Column(name="perc_7_t", type="float", nullable=true)
     */
    private $perc7T;

    /**
     * @var string|"0"
     *
     * @ORM\Column(name="perc_93_t", type="float", nullable=true)
     */
    private $perc93T;


    /**
     * @var integer|null
     * @Assert\NotBlank()
     * @ORM\Column(name="b_exposed_faces", type="integer", nullable=false)
     */
    private $exposedFaces;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @ORM\Column(name="b_conditioning", type="string", nullable=false)
     */
    private $conditioning;

    /**
     * @var float|null
     * @Assert\NotBlank()
     * @ORM\Column(name="b_width", type="float", nullable=false)
     */
    private $width;

    /**
     * @var float|null
     * @Assert\NotBlank()
     * @ORM\Column(name="b_high", type="float", nullable=false)
     */
    private $high;

    /**
     * @var float|null
     * @Assert\NotBlank()
     * @ORM\Column(name="b_length", type="float", nullable=false)
     */
    private $length;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @ORM\Column(name="b_roof_composition", type="string", nullable=false)
     */
    private $roofComposition;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @ORM\Column(name="b_floor_composition", type="string", nullable=false)
     */
    private $floorComposition;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @ORM\Column(name="b_wall_composition", type="string", nullable=false)
     */
    private $wallComposition;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @ORM\Column(name="b_window_composition", type="string", nullable=false)
     */
    private $windowComposition;

    /**
     * @var float|null
     * @Assert\NotBlank()
     * @ORM\Column(name="b_glazed_surface", type="float", nullable=false)
     */
    private $glazedSurface;


    /**
     * @ORM\ManyToOne(targetEntity="Library", inversedBy="rooms")
     * @ORM\JoinColumn(name="b_library_id", referencedColumnName="id")
     */
    private $library;


    /**
     * @var string|null
     * @Assert\NotBlank()
     * @ORM\Column(name="b_name", type="string", nullable=false, unique=false)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="DataLogger", mappedBy="room")
     */
    private $dataLoggers;

    /**
     * @var bool
     *
     * @ORM\Column(name="b_enabled", type="boolean", nullable=false)
     */
    private $enabled;

    public function __construct()
    {
        $this->dataLoggers = new \Doctrine\Common\Collections\ArrayCollection();
		$this->backing = 0.0;
		$this->transparency = 0.0;
		$this->thermalTransmittance = 0.0;
		$this->dough = 0.0;
        $this->enabled=true;
    }

    public function __toString()
    {
      return $this->name;
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
     * Set use.
     *
     * @param string|null $use
     *
     * @return Room
     */
    public function setUse($use = null)
    {
        $this->use = $use;

        return $this;
    }

    /**
     * Get use.
     *
     * @return string|null
     */
    public function getUse()
    {
        return $this->use;
    }

    /**
     * Set exposedFaces.
     *
     * @param int|null $exposedFaces
     *
     * @return Room
     */
    public function setExposedFaces($exposedFaces = null)
    {
        $this->exposedFaces = $exposedFaces;

        return $this;
    }

    /**
     * Get exposedFaces.
     *
     * @return int|null
     */
    public function getExposedFaces()
    {
        return $this->exposedFaces;
    }

    /**
     * Set conditioning.
     *
     * @param string|null $conditioning
     *
     * @return Room
     */
    public function setConditioning($conditioning = null)
    {
        $this->conditioning = $conditioning;

        return $this;
    }

    /**
     * Get conditioning.
     *
     * @return string|null
     */
    public function getConditioning()
    {
        return $this->conditioning;
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
     * @param float|null $high
     *
     * @return Room
     */
    public function setHigh($high = null)
    {
        $this->high = $high;

        return $this;
    }

    /**
     * Get high.
     *
     * @return float|null
     */
    public function getHigh()
    {
        return $this->high;
    }

    /**
     * Set length.
     *
     * @param float|null $length
     *
     * @return Room
     */
    public function setLength($length = null)
    {
        $this->length = $length;

        return $this;
    }

    /**
     * Get length.
     *
     * @return float|null
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Set roofComposition.
     *
     * @param string|null $roofComposition
     *
     * @return Room
     */
    public function setRoofComposition($roofComposition = null)
    {
        $this->roofComposition = $roofComposition;

        return $this;
    }

    /**
     * Get roofComposition.
     *
     * @return string|null
     */
    public function getRoofComposition()
    {
        return $this->roofComposition;
    }

    /**
     * Set floorComposition.
     *
     * @param string|null $floorComposition
     *
     * @return Room
     */
    public function setFloorComposition($floorComposition = null)
    {
        $this->floorComposition = $floorComposition;

        return $this;
    }

    /**
     * Get floorComposition.
     *
     * @return string|null
     */
    public function getFloorComposition()
    {
        return $this->floorComposition;
    }

    /**
     * Set wallComposition.
     *
     * @param string|null $wallComposition
     *
     * @return Room
     */
    public function setWallComposition($wallComposition = null)
    {
        $this->wallComposition = $wallComposition;

        return $this;
    }

    /**
     * Get wallComposition.
     *
     * @return string|null
     */
    public function getWallComposition()
    {
        return $this->wallComposition;
    }

    /**
     * Set windowComposition.
     *
     * @param string|null $windowComposition
     *
     * @return Room
     */
    public function setWindowComposition($windowComposition = null)
    {
        $this->windowComposition = $windowComposition;

        return $this;
    }

    /**
     * Get windowComposition.
     *
     * @return string|null
     */
    public function getWindowComposition()
    {
        return $this->windowComposition;
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

    /**
     * Add dataLogger.
     *
     * @param \AppBundle\Entity\DataLogger $dataLogger
     *
     * @return Room
     */
    public function addDataLogger(\AppBundle\Entity\DataLogger $dataLogger)
    {
        $this->dataLoggers[] = $dataLogger;

        return $this;
    }

    /**
     * Remove dataLogger.
     *
     * @param \AppBundle\Entity\DataLogger $dataLogger
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeDataLogger(\AppBundle\Entity\DataLogger $dataLogger)
    {
        return $this->dataLoggers->removeElement($dataLogger);
    }

    /**
     * Get dataLoggers.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDataLoggers()
    {
        return $this->dataLoggers;
    }

    /**
     * Set name.
     *
     * @param string|null $name
     *
     * @return Room
     */
    public function setName($name = null)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set enabled.
     *
     * @param bool $enabled
     *
     * @return Room
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
     * Set backing.
     *
     * @param string|"0" $backing
     *
     * @return Room
     */
    public function setBacking($backing = "0")
    {
        $this->backing = $backing;

        return $this;
    }

    /**
     * Get backing.
     *
     * @return string|"0"
     */
    public function getBacking()
    {
        return $this->backing;
    }

    /**
     * Set transparency.
     *
     * @param string|null $transparency
     *
     * @return Room
     */
    public function setTransparency($transparency = "0")
    {
        $this->transparency = $transparency;

        return $this;
    }

    /**
     * Get transparency.
     *
     * @return string|"0"
     */
    public function getTransparency()
    {
        return $this->transparency;
    }

    /**
     * Set thermalTransmittance.
     *
     * @param string|"0" $thermalTransmittance
     *
     * @return Room
     */
    public function setThermalTransmittance($thermalTransmittance = "0")
    {
        $this->thermalTransmittance = $thermalTransmittance;

        return $this;
    }

    /**
     * Get thermalTransmittance.
     *
     * @return string|"0"
     */
    public function getThermalTransmittance()
    {
        return $this->thermalTransmittance;
    }

    /**
     * Set dough.
     *
     * @param string|null $dough
     *
     * @return Room
     */
    public function setDough($dough = null)
    {
        $this->dough = $dough;

        return $this;
    }

    /**
     * Get dough.
     *
     * @return string|null
     */
    public function getDough()
    {
        return $this->dough;
    }

    /**
     * Set perc7H.
     *
     * @param float|null $perc7H
     *
     * @return Room
     */
    public function setPerc7H($perc7H = null)
    {
        $this->perc7H = $perc7H;

        return $this;
    }

    /**
     * Get perc7H.
     *
     * @return float|null
     */
    public function getPerc7H()
    {
        return $this->perc7H;
    }

    /**
     * Set perc93H.
     *
     * @param float|null $perc93H
     *
     * @return Room
     */
    public function setPerc93H($perc93H = null)
    {
        $this->perc93H = $perc93H;

        return $this;
    }

    /**
     * Get perc93H.
     *
     * @return float|null
     */
    public function getPerc93H()
    {
        return $this->perc93H;
    }

    /**
     * Set perc7T.
     *
     * @param float|null $perc7T
     *
     * @return Room
     */
    public function setPerc7T($perc7T = null)
    {
        $this->perc7T = $perc7T;

        return $this;
    }

    /**
     * Get perc7T.
     *
     * @return float|null
     */
    public function getPerc7T()
    {
        return $this->perc7T;
    }

    /**
     * Set perc93T.
     *
     * @param float|null $perc93T
     *
     * @return Room
     */
    public function setPerc93T($perc93T = null)
    {
        $this->perc93T = $perc93T;

        return $this;
    }

    /**
     * Get perc93T.
     *
     * @return float|null
     */
    public function getPerc93T()
    {
        return $this->perc93T;
    }
}
