<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Solicitation
 *
 * @ORM\Table(name="solicitation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SolicitationRepository")
 */
class Solicitation
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
     * Many Features have One Product.
     * @ORM\ManyToOne(targetEntity="Library", inversedBy="followers")
     * @ORM\JoinColumn(name="library_id", referencedColumnName="id")
     */
    private $library;

    /**
     * Many Features have One Product.
     * @ORM\ManyToOne(targetEntity="User", inversedBy="followings")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=255)
     */
    private $state;

    public function __construct()
    {
        $this->state = 'pending';
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
     * Set library.
     *
     * @param string $library
     *
     * @return Solicitation
     */
    public function setLibrary($library)
    {
        $this->library = $library;

        return $this;
    }

    /**
     * Get library.
     *
     * @return string
     */
    public function getLibrary()
    {
        return $this->library;
    }

    /**
     * Set user.
     *
     * @param string $user
     *
     * @return Solicitation
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set state.
     *
     * @param string $state
     *
     * @return Solicitation
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * change state to accepted
     */
    public function changeToAccepted()
    {
        $this->state = 'accepted';
        return $this;
    }

    /**
     * change state to canceled
     */
    public function changeToCanceled()
    {
        $this->state = 'canceled';
        return $this;
    }

    /**
     * Get state.
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }
}
