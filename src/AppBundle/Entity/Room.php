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
     * @var string|null
     *
     * @ORM\Column(name="b_use", type="string", nullable=true)
     */
    private $use;

    /**
     * @var integer|null
     *
     * @ORM\Column(name="b_exposed_faces", type="integer", nullable=true)
     */
    private $exposedFaces;

    /**
     * @var string|null
     *
     * @ORM\Column(name="b_conditioning", type="string", nullable=true)
     */
    private $conditioning;

    /**
     * @var float|null
     *
     * @ORM\Column(name="b_width", type="float", nullable=true)
     */
    private $width;

    /**
     * @var float|null
     *
     * @ORM\Column(name="b_high", type="float", nullable=true)
     */
    private $high;

    /**
     * @var float|null
     *
     * @ORM\Column(name="b_length", type="float", nullable=true)
     */
    private $length;

    /**
     * @var string|null
     *
     * @ORM\Column(name="b_roof_composition", type="string", nullable=true)
     */
    private $roofComposition;

    /**
     * @var string|null
     *
     * @ORM\Column(name="b_floor_composition", type="string", nullable=true)
     */
    private $floorComposition;

    /**
     * @var string|null
     *
     * @ORM\Column(name="b_wall_composition", type="string", nullable=true)
     */
    private $wallComposition;

    /**
     * @var string|null
     *
     * @ORM\Column(name="b_window_composition", type="string", nullable=true)
     */
    private $windowComposition;

    /**
     * @var float|null
     *
     * @ORM\Column(name="b_glazed_surface", type="float", nullable=true)
     */
    private $glazedSurface;


    /**
     * @ORM\ManyToOne(targetEntity="Library", inversedBy="rooms")
     * @ORM\JoinColumn(name="b_library_id", referencedColumnName="id")
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
}
