<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\ManyToMany(targetEntity="UserGroup", inversedBy="users")
     * @ORM\JoinTable(
     *  name="user_group_user",
     *  joinColumns={
     *      @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="user_group_id", referencedColumnName="id")
     *  }
     * )
     */
    private $groups;

    public function __construct() {
        $this->groups = new ArrayCollection();
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
     * @ORM\Column(name="name", type="string", length=50, unique=true)
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
     * Set uName
     *
     * @param string $uName
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get uName
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getGroups()
    {
        return $this->groups;
    }

    public function setGroups($groups)
    {
        $this->groups = $groups;
    }


    public function addUserGroup(UserGroup $group)
    {
        if ($this->groups->contains($group)) {
            return;
        }
        $this->groups->add($group);
        $group->addUser($this);
    }

    public function removeUserGroup(UserGroup $group)
    {
        if (!$this->groups->contains($group)) {
            return;
        }
        $this->groups->removeElement($group);
        $group->removeUser($this);
    }

}
