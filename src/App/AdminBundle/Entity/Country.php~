<?php

namespace App\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Country
 *
 * @ORM\Table(name="country_tb")
 * @ORM\Entity(repositoryClass="App\AdminBundle\Entity\CountryRepository")
 */
class Country
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
     * @ORM\Column(name="alpha_2_code", type="string", length=2)
     * @Assert\NotBlank()
     */
    private $alpha2Code;

    /**
     * @var string
     *
     * @ORM\Column(name="alpha_3_code", type="string", length=3)
     * @Assert\NotBlank()
     */
    private $alpha3Code;

    /**
     * @var integer
     *
     * @ORM\Column(name="numeric_code", type="integer")
     * @Assert\NotBlank()
     */
    private $numericCode;

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="locale")
     */
    protected $users;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Country
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
     * @return Country
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
     * Set alpha3Code
     *
     * @param string $alpha3Code
     * @return Country
     */
    public function setAlpha3Code($alpha3Code)
    {
        $this->alpha3Code = $alpha3Code;

        return $this;
    }

    /**
     * Get alpha3Code
     *
     * @return string 
     */
    public function getAlpha3Code()
    {
        return $this->alpha3Code;
    }

    /**
     * Set numericCode
     *
     * @param integer $numericCode
     * @return Country
     */
    public function setNumericCode($numericCode)
    {
        $this->numericCode = $numericCode;

        return $this;
    }

    /**
     * Get numericCode
     *
     * @return integer 
     */
    public function getNumericCode()
    {
        return $this->numericCode;
    }

    /**
     * Add users
     *
     * @param \App\AdminBundle\Entity\User $users
     * @return Country
     */
    public function addUser(\App\AdminBundle\Entity\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \App\AdminBundle\Entity\User $users
     */
    public function removeUser(\App\AdminBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
}
