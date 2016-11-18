<?php

namespace App\AdminBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * NotificationType
 *
 * @ORM\Table(name="notificationType_tb")
 * @ORM\Entity(repositoryClass="App\AdminBundle\Entity\NotificationTypeRepository")
 */
class NotificationType
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
     * @var ArrayCollection $notifications
     *
     * @ORM\OneToMany(targetEntity="Notification", mappedBy="notificationType", cascade={"all"}, fetch="EAGER")
     */
    private $notifications;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="notificationtypes")
     */
    private $users;

    /**
     * @inheritdoc
     */
    public function __construct()
    {
        $this->notifications = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return NotificationType
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
     * Add notification
     *
     * @param \App\AdminBundle\Entity\Notification $notification
     * @return NotificationType
     */
    public function addNotification(Notification $notification)
    {
        $this->notifications[] = $notification;
        return $this;
    }

    /**
     * Remove notification
     *
     * @param \App\AdminBundle\Entity\Notification $notification
     */
    public function removeNotification(Notification $notification)
    {
        $this->notifications->removeElement($notification);
    }

    /**
     * Get notifications
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * Add user
     *
     * @param \App\AdminBundle\Entity\User $user
     * @return NotificationType
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
