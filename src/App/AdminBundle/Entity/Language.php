<?php

namespace App\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Language
 *
 * @ORM\Table(name="language_tb")
 * @ORM\Entity(repositoryClass="App\AdminBundle\Entity\LanguageRepository")
 */
class Language
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="alpha2Code", type="string", length=2)
     * @Assert\NotBlank()
     */
    private $alpha2Code;

    /**
     * @ORM\ManyToOne(targetEntity="Description", inversedBy="languages")
     * @ORM\JoinColumn(name="description_id", referencedColumnName="id", nullable=false)
     */
    private $description;


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
     * @return Language
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
     * Set alpha2Code
     *
     * @param string $alpha2Code
     * @return Language
     */
    public function setAlpha2Code($alpha2Code)
    {
        $this->alpha2Code = $alpha2Code;

        return $this;
    }

    /**
     * Get alpha2Code
     *
     * @return string 
     */
    public function getAlpha2Code()
    {
        return $this->alpha2Code;
    }

    /**
     * Set description
     *
     * @param \App\AdminBundle\Entity\Description $description
     * @return Language
     */
    public function setDescription(\App\AdminBundle\Entity\Description $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return \App\AdminBundle\Entity\Description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}
