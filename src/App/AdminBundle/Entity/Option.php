<?php

namespace App\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="option_tb")
 * @ORM\Entity(repositoryClass="App\AdminBundle\Entity\OptionRepository")
 */
class Option
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true, nullable=false)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="string", unique=true, nullable=true)
     */
    private $path;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\NotBlank()
     */
    private $icon;

    /**
     * @ORM\ManyToMany(targetEntity="Role", mappedBy="options")
     */
    private $roles;

    /**
     * @var ArrayCollection $options
     *
     * @ORM\OneToMany(targetEntity="Option", mappedBy="asociatedOption", cascade={"all"}, fetch="EAGER")
     */
    private $options;

    /**
     * @var Option $asociatedOption
     *
     * @ORM\ManyToOne(targetEntity="Option", inversedBy="options", fetch="EAGER")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="asociatedOption_id", referencedColumnName="id")
     * })
     */
    private $asociatedOption;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->options = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @return Option
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
     * Set path
     *
     * @param string $path
     * @return Option
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set icon
     *
     * @param string $icon
     * @return Option
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Add role
     *
     * @param \App\AdminBundle\Entity\Role $role
     * @return Option
     */
    public function addRole(\App\AdminBundle\Entity\Role $role)
    {
        $this->roles[] = $role;

        return $this;
    }

    /**
     * Remove role
     *
     * @param \App\AdminBundle\Entity\Role $role
     */
    public function removeRole(\App\AdminBundle\Entity\Role $role)
    {
        $this->roles->removeElement($role);
    }

    /**
     * Get roles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @return array|ArrayCollection
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array|ArrayCollection $options
     */
    public function setOptions($options)
    {
        foreach ($options as $child) {
            $this->options->add($child);
        }
    }

    /**
     * @param Option $asociatedOption
     */
    public function setAsociatedOption($asociatedOption)
    {
        $this->asociatedOption = $asociatedOption;
    }

    /**
     * @return Option
     */
    public function getAsociatedOption()
    {
        return $this->asociatedOption;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * Add options
     *
     * @param \App\AdminBundle\Entity\Option $options
     * @return Option
     */
    public function addOption(\App\AdminBundle\Entity\Option $options)
    {
        $this->options[] = $options;

        return $this;
    }

    /**
     * Remove options
     *
     * @param \App\AdminBundle\Entity\Option $options
     */
    public function removeOption(\App\AdminBundle\Entity\Option $options)
    {
        $this->options->removeElement($options);
    }
}
