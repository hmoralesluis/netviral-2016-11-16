<?php

namespace App\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BankAccount
 *
 * @ORM\Table(name="bank_tb")
 * @ORM\Entity(repositoryClass="App\AdminBundle\Entity\BankAccountRepository")
 */
class BankAccount
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
     * @ORM\Column(name="code", type="string")
     */
    private $code;

    /**
     * @var float
     *
     * @ORM\Column(name="money", type="float")
     */
    private $money;

    /** @var \DateTime
     *
     * @ORM\Column(name="lastUpdate", type="date")
     */
    private $lastUpdate;

    /**
     *
     * @ORM\OneToOne(targetEntity="User", mappedBy="bankAccount")
     */
    protected $user;

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
     * Set code
     *
     * @param string $code
     * @return BankAccount
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set money
     *
     * @param float $money
     * @return BankAccount
     */
    public function setMoney($money)
    {
        $this->money = $money;

        return $this;
    }

    /**
     * Get money
     *
     * @return float 
     */
    public function getMoney()
    {
        return $this->money;
    }

    /**
     * @return \DateTime
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }

    /**
     * @param \DateTime $lastUpdate
     * @return BankAccount
     */
    public function setLastUpdate($lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;
        return $this;
    }

    /**
     * Set user
     *
     * @param \App\AdminBundle\Entity\User $user
     * @return BankAccount
     */
    public function setUser(\App\AdminBundle\Entity\User $user = null)
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
}
