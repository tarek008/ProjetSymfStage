<?php
// src/Entity/User.php

namespace App\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\EntityManager;


/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
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
     *
     * @ORM\Column(name="image", type="string", length=255)
     * @Assert\File(maxSize="500k", mimeTypes={"image/jpeg", "image/jpg", "image/png", "image/GIF"})
     */
    protected $image ;

    /**
     * @ORM\Column(type="string")
     */protected $presence;

    /**
     * @ORM\Column(type="integer")
     */protected $nbrhworked;

    /**
     * @ORM\Column(type="integer")
     */protected $remunerationtotal;


    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @return string
     */

    public function getRole()
    {

        foreach ($this->getRoles() as $role) {
            $var = $role;
        }
        return $var;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getpresence()
    {
        return $this->presence;
    }

    /**
     * @param mixed $presence
     */
    public function setpresence($presence)
    {
        $this->presence = $presence;
    }

    /**
     * @return mixed
     */
    public function getnbrhworked()
    {
        return $this->nbrhworked;
    }

    /**
     * @param mixed $nbrhworked
     */
    public function setnbrhworked($nbrhworked)
    {
        $this->nbrhworked = $nbrhworked;
    }

    /**
     * @return mixed $remunerationtotal
     */
    public function getremunerationtotal()
    {
        return $this->remunerationtotal;
    }

    /**
     * @param mixed $remunerationtotal
     */
    public function setremunerationtotal($remunerationtotal)
    {
        $this->remunerationtotal = $remunerationtotal;
    }


    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
