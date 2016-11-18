<?php

namespace App\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BenefitTable
 *
 * @ORM\Table(name="benefitTable_tb")
 * @ORM\Entity(repositoryClass="App\AdminBundle\Entity\BenefitTableRepository")
 */
class BenefitTable
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
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="directBenefitTable")
     */
    private $directBenefitList;

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="indirectBenefitTable")
     */
    private $indirectBenefitList;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->directBenefitList = new \Doctrine\Common\Collections\ArrayCollection();
        $this->indirectBenefitList = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set username
     *
     * @param string $username
     * @return BenefitTable
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Add directBenefitList
     *
     * @param \App\AdminBundle\Entity\User $directBenefit
     * @return BenefitTable
     */
    public function addDirectBenefit(\App\AdminBundle\Entity\User $directBenefit)
    {
        $this->directBenefitList[] = $directBenefit;

        return $this;
    }

    /**
     * Remove directBenefit
     *
     * @param \App\AdminBundle\Entity\User $directBenefit
     */
    public function removeDirectBenefit(\App\AdminBundle\Entity\User $directBenefit)
    {
        $this->directBenefitList->removeElement($directBenefit);
    }

    /**
     * Get directBenefit
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDirectBenefitList()
    {
        return $this->directBenefitList;
    }

    /**
     * Add indirectBenefitList
     *
     * @param \App\AdminBundle\Entity\User $indirectBenefit
     * @return BenefitTable
     */
    public function addIndirectBenefit(\App\AdminBundle\Entity\User $indirectBenefit)
    {
        $this->indirectBenefitList[] = $indirectBenefit;

        return $this;
    }

    /**
     * Remove indirectBenefitList
     *
     * @param \App\AdminBundle\Entity\User $indirectBenefit
     */
    public function removeIndirectBenefit(\App\AdminBundle\Entity\User $indirectBenefit)
    {
        $this->indirectBenefitList->removeElement($indirectBenefit);
    }

    /**
     * Get indirectBenefit
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIndirectBenefitList()
    {
        return $this->indirectBenefitList;
    }

    /**
     * Add directBenefitList
     *
     * @param \App\AdminBundle\Entity\User $directBenefitList
     * @return BenefitTable
     */
    public function addDirectBenefitList(\App\AdminBundle\Entity\User $directBenefitList)
    {
        $this->directBenefitList[] = $directBenefitList;

        return $this;
    }

    /**
     * Remove directBenefitList
     *
     * @param \App\AdminBundle\Entity\User $directBenefitList
     */
    public function removeDirectBenefitList(\App\AdminBundle\Entity\User $directBenefitList)
    {
        $this->directBenefitList->removeElement($directBenefitList);
    }

    /**
     * Add indirectBenefitList
     *
     * @param \App\AdminBundle\Entity\User $indirectBenefitList
     * @return BenefitTable
     */
    public function addIndirectBenefitList(\App\AdminBundle\Entity\User $indirectBenefitList)
    {
        $this->indirectBenefitList[] = $indirectBenefitList;

        return $this;
    }

    /**
     * Remove indirectBenefitList
     *
     * @param \App\AdminBundle\Entity\User $indirectBenefitList
     */
    public function removeIndirectBenefitList(\App\AdminBundle\Entity\User $indirectBenefitList)
    {
        $this->indirectBenefitList->removeElement($indirectBenefitList);
    }
}
