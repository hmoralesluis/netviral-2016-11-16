<?php

namespace App\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\AdminBundle\Entity\ModuleOptionRepository")
 * @ORM\Table(name="moduleoption_tb")
 */

class ModuleOption
{

    /**
     * @ORM\id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */

    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */

    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\AdminBundle\Entity\Module")
     */
    private $module;



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
     * Set name
     *
     * @param string $name
     * @return ModuleOption
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set module
     *
     * @param \App\AdminBundle\Entity\Module $module
     * @return ModuleOption
     */
    public function setModule(\App\AdminBundle\Entity\Module $module = null)
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

    public function _toString()
    {
        return $this->getName();
    }

}
