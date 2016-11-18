<?php

namespace App\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ShopSubcategoryProduct
 *
 * @ORM\Entity(repositoryClass="App\AdminBundle\Entity\ShopSubcategoryProductRepository")
 * @ORM\HasLifecycleCallbacks
 */
class ShopSubcategoryProduct
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
    private $filename;

    /**
     * @ORM\Column(type="float", nullable=false)
     * @Assert\NotBlank()
     */
    private $price;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\NotBlank()
     */
    private $Deliverytime;

    /**
     *
     * @ORM\ManyToOne(targetEntity="ShopSubcategory", cascade={"all"}, fetch="EAGER")
     */
    private $subcategory;

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
     * Set filename
     *
     * @param string $filename
     * @return ShopSubcategoryProduct
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string 
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return ShopSubcategoryProduct
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set Deliverytime
     *
     * @param string $deliverytime
     * @return ShopSubcategoryProduct
     */
    public function setDeliverytime($deliverytime)
    {
        $this->Deliverytime = $deliverytime;

        return $this;
    }

    /**
     * Get Deliverytime
     *
     * @return string 
     */
    public function getDeliverytime()
    {
        return $this->Deliverytime;
    }

    /**
     * Set subcategory
     *
     * @param \App\AdminBundle\Entity\ShopSubcategory $subcategory
     * @return ShopSubcategoryProduct
     */
    public function setSubcategory(\App\AdminBundle\Entity\ShopSubcategory $subcategory = null)
    {
        $this->subcategory = $subcategory;

        return $this;
    }

    /**
     * Get subcategory
     *
     * @return \App\AdminBundle\Entity\ShopSubcategory 
     */
    public function getSubcategory()
    {
        return $this->subcategory;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

}
