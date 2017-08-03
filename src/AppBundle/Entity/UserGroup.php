<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * UserGroup
 *
 * @ORM\Table(name="user_group")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserGroupRepository")
 */
class UserGroup
{

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="groups")

     */
    protected $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set gName
     *
     * @param string $gName
     * @return UserGroup
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get gName
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    
    public function __toString()
    {
        return $this->getName();
    }

    public function setUsers($users)
    {
        $this->users = $users;
    }
    
    public function getUsers()
    {
        return $this->users;
    }
    
    public function addUser(User $user)
    {
        if ($this->users->contains($user)) {
            return;
        }
        $this->users->add($user);
        $user->addUserGroup($this);
    }
    
    public function removeUser(User $user)
    {
        if (!$this->users->contains($user)) {
            return;
        }
        $this->users->removeElement($user);
        $user->removeUserGroup($this);
    }

        
    
}
