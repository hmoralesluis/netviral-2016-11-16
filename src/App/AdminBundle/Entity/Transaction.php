<?php

namespace App\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transaction
 *
 * @ORM\Table(name="transaction_tb")
 * @ORM\Entity(repositoryClass="App\AdminBundle\Entity\TransactionRepository")
 */
class Transaction
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="generation", type="integer")
     */
    private $generation;

    /**
     * @var string
     *
     * @ORM\Column(name="nickname", type="string")
     */
    private $nickname;

    /**
     * @var float
     *
     * @ORM\Column(name="money", type="float")
     */
    private $money;

    /**
     * @var string
     *
     * @ORM\Column(name="module", type="string")
     */
    private $module;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="transactions")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="TransactionType", inversedBy="transactions")
     * @ORM\JoinColumn(name="transactionType_id", referencedColumnName="id", nullable=false)
     */
    private $transactionType;

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
     * Set date
     *
     * @param \DateTime $date
     * @return Transaction
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set generation
     *
     * @param integer $generation
     * @return Transaction
     */
    public function setGeneration($generation)
    {
        $this->generation = $generation;

        return $this;
    }

    /**
     * Get generation
     *
     * @return integer
     */
    public function getGeneration()
    {
        return $this->generation;
    }

    /**
     * Set user
     *
     * @param \App\AdminBundle\Entity\User $user
     * @return Transaction
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
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @param string $nickname
     * @return Transaction
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
        return $this;
    }

    /**
     * @return string
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @param string $module
     * @return Transaction
     */
    public function setModule($module)
    {
        $this->module = $module;
        return $this;
    }

    /**
     * @return float
     */
    public function getMoney()
    {
        return $this->money;
    }

    /**
     * @param float $money
     * @return Transaction
     */
    public function setMoney($money)
    {
        $this->money = $money;
        return $this;
    }

    /**
     * @return TransactionType
     */
    public function getTransactionType()
    {
        return $this->transactionType;
    }

    /**
     * @param TransactionType $transactionType
     * @return Transaction
     */
    public function setTransactionType($transactionType)
    {
        $this->transactionType = $transactionType;
        return $this;
    }
}
