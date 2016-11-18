<?php

namespace App\AdminBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Product
 *
 * @ORM\Table(name="product_tb")
 * @ORM\Entity(repositoryClass="App\AdminBundle\Entity\ProductRepository")
 */
class Product
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
     * @var integer
     *
     * @ORM\Column(name="count", type="integer")
     */
    private $count;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     * @Assert\NotBlank()
     */
    private $price;

    /**
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="products")
     * @ORM\JoinTable(name="product_role_tb", joinColumns={@ORM\JoinColumn
    (name="product_id", referencedColumnName="id")}, inverseJoinColumns=
    {@ORM\JoinColumn(name="role_id", referencedColumnName="id")})
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity="Description", mappedBy="product")
     */
    private $descriptions;

    /**
     * @ORM\ManyToOne(targetEntity="ProductType", inversedBy="products")
     * @ORM\JoinColumn(name="productType_id", referencedColumnName="id", nullable=false)
     */
    private $productType;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="products")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="Module", mappedBy="products")
     */
    private $modules;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->descriptions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->modules = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Product
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
     * Set count
     *
     * @param integer $count
     * @return Product
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get count
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return Product
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
     * Add roles
     *
     * @param \App\AdminBundle\Entity\Role $roles
     * @return Product
     */
    public function addRole(\App\AdminBundle\Entity\Role $roles)
    {
        $this->roles[] = $roles;

        return $this;
    }

    /**
     * Remove roles
     *
     * @param \App\AdminBundle\Entity\Role $roles
     */
    public function removeRole(\App\AdminBundle\Entity\Role $roles)
    {
        $this->roles->removeElement($roles);
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
     * Add description
     *
     * @param \App\AdminBundle\Entity\Description $description
     * @return Product
     */
    public function addDescription(\App\AdminBundle\Entity\Description $description)
    {
        $this->descriptions[] = $description;

        return $this;
    }

    /**
     * Remove description
     *
     * @param \App\AdminBundle\Entity\Description $description
     */
    public function removeDescription(\App\AdminBundle\Entity\Description $description)
    {
        $this->descriptions->removeElement($description);
    }

    /**
     * Get descriptions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDescriptions()
    {
        return $this->descriptions;
    }

    /**
     * Set productType
     *
     * @param \App\AdminBundle\Entity\ProductType $productType
     * @return Product
     */
    public function setProductType(\App\AdminBundle\Entity\ProductType $productType)
    {
        $this->productType = $productType;

        return $this;
    }

    /**
     * Get productType
     *
     * @return \App\AdminBundle\Entity\ProductType
     */
    public function getProductType()
    {
        return $this->productType;
    }

    /**
     * Set user
     *
     * @param \App\AdminBundle\Entity\User $user
     * @return Product
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
     * Add module
     *
     * @param \App\AdminBundle\Entity\Module $module
     * @return Product
     */
    public function addModule(\App\AdminBundle\Entity\Module $module)
    {
        $this->modules[] = $module;

        return $this;
    }

    /**
     * Remove module
     *
     * @param \App\AdminBundle\Entity\Module $module
     */
    public function removeModule(\App\AdminBundle\Entity\Module $module)
    {
        $this->modules->removeElement($module);
    }

    /**
     * Get modules
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getModules()
    {
        return $this->modules;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}
