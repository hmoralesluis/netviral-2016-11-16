<?php

namespace App\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ShopSubcategory
 *
 * @ORM\Entity(repositoryClass="App\AdminBundle\Entity\ShopSubcategoryRepository")
 * @ORM\HasLifecycleCallbacks
 */
class ShopSubcategory
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     *
     * @ORM\ManyToOne(targetEntity="ShopCategory", fetch="EAGER")
     */
    private $category;


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
     * @return ShopSubcategory
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
     * Set category
     *
     * @param \App\AdminBundle\Entity\ShopCategory $category
     * @return ShopSubcategory
     */
    public function setCategory(\App\AdminBundle\Entity\ShopCategory $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \App\AdminBundle\Entity\ShopCategory 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }


}
