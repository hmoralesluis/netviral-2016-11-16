<?php

namespace App\AdminBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Notification
 *
 * @ORM\Table(name="notification_tb")
 * @ORM\Entity(repositoryClass="App\AdminBundle\Entity\NotificationRepository")
 */
class Notification
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
     * @Assert\NotBlank()
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="NotificationType", inversedBy="notifications")
     * @ORM\JoinColumn(name="notificationType_id", referencedColumnName="id", nullable=false)
     */
    private $notificationType;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="notifications")
     * @ORM\JoinTable(name="notification_user_tb", joinColumns={@ORM\JoinColumn
    (name="notification_id", referencedColumnName="id")}, inverseJoinColumns=
    {@ORM\JoinColumn(name="user_id", referencedColumnName="id")})
     */
    private $users;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
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
     * Set date
     *
     * @param \DateTime $date
     * @return Notification
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
     * Set notificationType
     *
     * @param \App\AdminBundle\Entity\NotificationType $type
     * @return Notification
     */
    public function setNotificationType(NotificationType $type)
    {
        $this->notificationType = $type;

        return $this;
    }

    /**
     * Get notificationType
     *
     * @return \App\AdminBundle\Entity\NotificationType
     */
    public function getNotificationType()
    {
        return $this->notificationType;
    }

    /**
     * Add user
     *
     * @param \App\AdminBundle\Entity\User $user
     * @return Notification
     */
    public function addUser(\App\AdminBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \App\AdminBundle\Entity\User $user
     */
    public function removeUser(\App\AdminBundle\Entity\User $user)
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
}
