<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Library
 *
 * @ORM\Table(name="library")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LibraryRepository")
 */
class Library
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
     * @var float
     *
     * @ORM\Column(name="latitude", type="float")
     */
    private $latitude;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float")
     */
    private $longitude;

    /**
     * @var int
     *
     * @ORM\Column(name="age", type="integer")
     */
    private $age;

    /**
     * @ORM\OneToMany(targetEntity="Room", mappedBy="library")
     */
    private $rooms;

    public function __construct()
    {
        $this->rooms = new ArrayCollection();
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
     * Set latitude.
     *
     * @param float $latitude
     *
     * @return Library
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude.
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude.
     *
     * @param float $longitude
     *
     * @return Library
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude.
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set age.
     *
     * @param int $age
     *
     * @return Library
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age.
     *
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Add room.
     *
     * @param \AppBundle\Entity\Room $room
     *
     * @return Library
     */
    public function addRoom(\AppBundle\Entity\Room $room)
    {
        $this->rooms[] = $room;

        return $this;
    }

    /**
     * Remove room.
     *
     * @param \AppBundle\Entity\Room $room
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeRoom(\AppBundle\Entity\Room $room)
    {
        return $this->rooms->removeElement($room);
    }

    /**
     * Get rooms.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRooms()
    {
        return $this->rooms;
    }
}
