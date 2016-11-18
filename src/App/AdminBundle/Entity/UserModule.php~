<?php

namespace App\AdminBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Module
 *
 * @ORM\Table(name="user_module_tb")
 * @ORM\Entity(repositoryClass="App\AdminBundle\Entity\UserModuleRepository")
 */
class UserModule
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userModule")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Module", inversedBy="userModule")
     * @ORM\JoinColumn(name="module_id", referencedColumnName="id", nullable=false)
     */
    private $module;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="activationDate", type="date")
     */
    private $activationDate;

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
     * Set activationDate
     *
     * @param \DateTime $activationDate
     * @return UserModule
     */
    public function setActivationDate($activationDate)
    {
        $this->activationDate = $activationDate;

        return $this;
    }

    /**
     * Get activationDate
     *
     * @return \DateTime
     */
    public function getActivationDate()
    {
        return $this->activationDate;
    }

    /**
     * Set user
     *
     * @param \App\AdminBundle\Entity\User $user
     * @return UserModule
     */
    public function setUser(\App\AdminBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \App\AdminBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set module
     *
     * @param \App\AdminBundle\Entity\Module $module
     * @return UserModule
     */
    public function setModule(\App\AdminBundle\Entity\Module $module)
    {
        $this->module = $module;

        return $this;
    }

    /**
     * Get module
     *
     * @return \App\AdminBundle\Entity\Module
     */
    public function getModule()
    {
        return $this->module;
    }
}
