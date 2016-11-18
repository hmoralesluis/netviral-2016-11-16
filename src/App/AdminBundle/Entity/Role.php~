<?php

namespace App\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Role\RoleInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Role
 *
 * @ORM\Table(name="role_tb")
 * @ORM\Entity(repositoryClass="App\AdminBundle\Entity\RoleRepository")
 */
class Role implements RoleInterface
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=30, unique=true, nullable=false)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var boolean
     * @ORM\Column(name="isPayment", type="boolean")
     */
    private $is_payment;

    /**
     * @var string
     * @ORM\Column(name="role", type="string", length=20, unique=true, nullable=false)
     * @Assert\NotBlank()
     */
    private $role;

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="role")
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity="Option", inversedBy="roles")
     * @ORM\JoinTable(name="role_option_tb", joinColumns={@ORM\JoinColumn
    (name="role_id", referencedColumnName="id")}, inverseJoinColumns=
    {@ORM\JoinColumn(name="option_id", referencedColumnName="id")})
     */
    private $options;

    /**
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="roles")
     */
    private $products;

    /**
     * @inheritdoc
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->options = new ArrayCollection();
        $this->products = new ArrayCollection();
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
     * @return Role
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
     * Set role
     *
     * @param string $role
     * @throws \InvalidArgumentException
     * @return Role
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Add user
     *
     * @param User $user
     * @return Role
     */
    public function addUser(User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param User $user
     */
    public function removeUser(User $user)
    {
        $this->users->removeElement($user);
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

    /**
     * Add option
     *
     * @param \App\AdminBundle\Entity\Option $option
     * @return Role
     */
    public function addOption(\App\AdminBundle\Entity\Option $option)
    {
        $this->options[] = $option;

        return $this;
    }

    /**
     * Remove option
     *
     * @param \App\AdminBundle\Entity\Option $option
     */
    public function removeOption(\App\AdminBundle\Entity\Option $option)
    {
        $this->options->removeElement($option);
    }

    /**
     * Get options
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Add product
     *
     * @param \App\AdminBundle\Entity\Product $product
     * @return Role
     */
    public function addProduct(\App\AdminBundle\Entity\Product $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \App\AdminBundle\Entity\Role $role
     */
    public function removeProduct(\App\AdminBundle\Entity\Product $product)
    {
        $this->products->removeElement($product);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @return boolean
     */
    public function isPayment()
    {
        return $this->is_payment;
    }

    /**
     * @param boolean $is_payment
     * @return Role
     */
    public function setIsPayment($is_payment)
    {
        $this->is_payment = $is_payment;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * Get is_payment
     *
     * @return boolean 
     */
    public function getIsPayment()
    {
        return $this->is_payment;
    }
}
