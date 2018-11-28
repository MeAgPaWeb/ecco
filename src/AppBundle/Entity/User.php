<?php
namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\Table(name="`user`")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank(message="Por favor, ingrese un nombre", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="El nombre ingresado es muy corto",
     *     maxMessage="El nombre ingresado es muy largo",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $name;

    /**
     * @ORM\Column(name="lastname", type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank(message="Por favor, ingrese un apellido", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="El apellido ingresado es muy corto",
     *     maxMessage="El apellido ingresado es muy largo",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $lastname;

    /**
     * @ORM\Column(name="registered_at", type="integer", nullable=false)
     */
    protected $registeredAt;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $avatar;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $gender;

    /**
     * One User has Many Follow-up Solicitations.
     * @ORM\OneToMany(targetEntity="Solicitation", mappedBy="user")
     */
    protected $followings;

    public function __construct($configurations = null){
        parent::__construct();
        $this->registeredAt = time();
        $this->followings = new \Doctrine\Common\Collections\ArrayCollection();
        //$this->comments = new \Doctrine\Common\Collections\ArrayCollection();
        //$this->editions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId(){
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setName($name){
        $this->name = $name;
        return $this;
    }
    /**
     * Get name
     *
     * @return string
     */
    public function getName(){
        return $this->name;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return User
     */
    public function setLastName($lastname){
        $this->lastname = $lastname;
        return $this;
    }
    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastName(){
        return $this->lastname;
    }

    /**
     * Get registeredAt
     *
     * @return string
     */
    public function getRegisteredAt(){
        return $this->registeredAt;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     * @return User
     */
    public function setAvatar($avatar){
        $this->avatar = $avatar;
        return $this;
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getAvatar(){
        if ($this->avatar == null){
          if (!$this->getGender()) {
            $this->gender="Male";
          }
            return $this->getGender().'_gender.jpg';
        }else{
            return $this->avatar;
        }
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return User
     */
    public function setGender($gender){
        $this->gender = $gender;
        return $this;
    }
    /**
     * Get gender
     *
     * @return string
     */
    public function getGender(){
        return $this->gender;
    }

    /**
     * Set registeredAt
     *
     * @param integer $registeredAt
     *
     * @return User
     */
    public function setRegisteredAt($registeredAt)
    {
        $this->registeredAt = $registeredAt;

        return $this;
    }

    /**
     * Add following.
     *
     * @param \AppBundle\Entity\Solicitation $following
     *
     * @return User
     */
    public function addFollowing(\AppBundle\Entity\Solicitation $following)
    {
        $this->followings[] = $following;

        return $this;
    }

    /**
     * Remove following.
     *
     * @param \AppBundle\Entity\Solicitation $following
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeFollowing(\AppBundle\Entity\Solicitation $following)
    {
        return $this->followings->removeElement($following);
    }

    /**
     * Get followings.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFollowings()
    {
        return $this->followings;
    }
}
