<?php

namespace App\AdminBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Encoder;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="user_tb")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="App\AdminBundle\Entity\UserRepository")
 */
class User implements UserInterface, AdvancedUserInterface, \Serializable
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\NotBlank()
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\Choice({"Hombre","Mujer"})
     * @Assert\NotBlank()
     */
    private $sex;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\Email(message = "The email '{{ value }}' is not a valid email.", checkMX = true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", unique=true, nullable=false)
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\NotBlank()
     */
    private $password;

    /**
     * @ORM\Column(name="salt", type="string", length=32, nullable=false)
     */
    private $salt;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $contactPhone;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $skype;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $whatsapp;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $facebook;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $twitter;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $google;

    /**
     *
     * @ORM\Column(type="date", nullable=false)
     */
    private $signUpDate;

    /**
     *
     * @ORM\Column(type="date", nullable=true)
     */
    private $birthday;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $generation;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $positionInGeneration;

    /** @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $photoExtension;

    /**
     * @var text
     * @ORM\Column(type="text", nullable=true)
     */
    private $about;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $active;

    /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="users")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id", nullable=false)
     * @Assert\Country()
     */
    private $locale;

    /**
     * @ORM\ManyToOne(targetEntity="Role", inversedBy="users")
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id", nullable=false)
     */
    private $role;

    /**
     * @var ArrayCollection $networkUsers
     *
     * @ORM\OneToMany(targetEntity="User", mappedBy="associatedUser", cascade={"all"}, fetch="EAGER")
     */
    private $networkUsers;

    /**
     * @var User $associatedUser
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="networkUsers", fetch="EAGER")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="associatedUser_id", referencedColumnName="id")
     * })
     */
    private $associatedUser;

    /**
     * @ORM\ManyToOne(targetEntity="BenefitTable", inversedBy="directBenefitList")
     * @ORM\JoinColumn(name="directBenefitTable_id", referencedColumnName="id", nullable=true)
     */
    private $directBenefitTable;

    /**
     * @ORM\ManyToOne(targetEntity="BenefitTable", inversedBy="indirectBenefitList")
     * @ORM\JoinColumn(name="indirectBenefitTable_id", referencedColumnName="id", nullable=true)
     */
    private $indirectBenefitTable;

    /**
     * @ORM\ManyToMany(targetEntity="Notification", mappedBy="users")
     */
    private $notifications;

    /**
     * @ORM\ManyToMany(targetEntity="NotificationType", inversedBy="users")
     * @ORM\JoinTable(name="user_notificationtype_tb", joinColumns={@ORM\JoinColumn
     * (name="user_id", referencedColumnName="id")}, inverseJoinColumns=
     * {@ORM\JoinColumn(name="notificationtype_id", referencedColumnName="id")})
     */
    private $notificationtypes;

    /**
     * @var ArrayCollection $products
     *
     * @ORM\OneToMany(targetEntity="Product", mappedBy="user", cascade={"all"}, fetch="EAGER")
     */
    private $products;

    /**
     * @var ArrayCollection $transactions
     *
     * @ORM\OneToMany(targetEntity="Transaction", mappedBy="user", cascade={"all"}, fetch="EAGER")
     */
    private $transactions;

    /**
     * @var ArrayCollection $userModule
     *
     * @ORM\OneToMany(targetEntity="UserModule", mappedBy="user", cascade={"all"}, fetch="EAGER")
     */
    protected $userModule;

    /**
     * @ORM\OneToOne(targetEntity="BankAccount", inversedBy="user")
     * @ORM\JoinColumn(name="bankAccount_id", referencedColumnName="id", nullable=false)
     */
    private $bankAccount;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->networkUsers = new ArrayCollection();
        $this->salt = md5(uniqid(null, true));
        $this->notifications = new ArrayCollection();
        $this->products = new ArrayCollection();
        $this->transactions = new ArrayCollection();
        $this->notificationtypes = new ArrayCollection();
        $this->userModule = new ArrayCollection();
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
     * @return User
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
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set sex
     *
     * @param string $sex
     * @return User
     */
    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getSex()
    {
        return $this->sex;
    }


    /**
     * Set username
     *
     * @param string $username
     * @return User
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
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $encoder = new \Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder('sha512', true, 10);
        $this->password = $encoder->encodePassword($password, $this->salt);
        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set contactPhone
     *
     * @param string $contactPhone
     * @return User
     */
    public function setContactPhone($contactPhone)
    {
        $this->contactPhone = $contactPhone;

        return $this;
    }

    /**
     * Get contactPhone
     *
     * @return string
     */
    public function getContactPhone()
    {
        return $this->contactPhone;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return User
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set skype
     *
     * @param string $skype
     * @return User
     */
    public function setSkype($skype)
    {
        $this->skype = $skype;

        return $this;
    }

    /**
     * Get skype
     *
     * @return string
     */
    public function getSkype()
    {
        return $this->skype;
    }

    /**
     * Set whatsapp
     *
     * @param string $whatsapp
     * @return User
     */
    public function setWhatsapp($whatsapp)
    {
        $this->whatsapp = $whatsapp;

        return $this;
    }

    /**
     * Get whatsapp
     *
     * @return string
     */
    public function getWhatsapp()
    {
        return $this->whatsapp;
    }

    /**
     * Set facebook
     *
     * @param string $facebook
     * @return User
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook
     *
     * @return string
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set twitter
     *
     * @param string $twitter
     * @return User
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Get twitter
     *
     * @return string
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Set google
     *
     * @param string $google
     * @return User
     */
    public function setGoogle($google)
    {
        $this->google = $google;

        return $this;
    }

    /**
     * Get google
     *
     * @return string
     */
    public function getGoogle()
    {
        return $this->google;
    }

    /**
     * Set signUpDate
     *
     * @param \DateTime $signUpDate
     * @return User
     */
    public function setSignUpDate($signUpDate)
    {
        $this->signUpDate = $signUpDate;

        return $this;
    }

    /**
     * Get signUpDate
     *
     * @return \DateTime
     */
    public function getSignUpDate()
    {
        return $this->signUpDate;
    }

    /**
     * Set generation
     *
     * @param integer $generation
     * @return User
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
     * Set positionInGeneration
     *
     * @param integer $positionInGeneration
     * @return User
     */
    public function setPositionInGeneration($positionInGeneration)
    {
        $this->positionInGeneration = $positionInGeneration;

        return $this;
    }

    /**
     * Get positionInGeneration
     *
     * @return integer
     */
    public function getPositionInGeneration()
    {
        return $this->positionInGeneration;
    }

    /**
     * Set photoExtension
     *
     * @param string $photoExtension
     * @return User
     */
    public function setPhotoExtension($photoExtension)
    {
        $this->photoExtension = $photoExtension;

        return $this;
    }

    /**
     * Get photoExtension
     *
     * @return string
     */
    public function getPhotoExtension()
    {
        return $this->photoExtension;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return User
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set locale
     *
     * @param \App\AdminBundle\Entity\Country $country
     * @return User
     */
    public function setLocale(\App\AdminBundle\Entity\Country $country)
    {
        $this->locale = $country;

        return $this;
    }

    /**
     * Get locale
     *
     * @return \App\AdminBundle\Entity\Country
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set role
     *
     * @param \App\AdminBundle\Entity\Role $role
     * @return User
     */
    public function setRole(\App\AdminBundle\Entity\Role $role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \App\AdminBundle\Entity\Role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Add networkUsers
     *
     * @param \App\AdminBundle\Entity\User $networkUsers
     * @return User
     */
    public function addNetworkUser(\App\AdminBundle\Entity\User $networkUsers)
    {
        $this->networkUsers[] = $networkUsers;

        return $this;
    }

    /**
     * Remove networkUsers
     *
     * @param \App\AdminBundle\Entity\User $networkUsers
     */
    public function removeNetworkUser(\App\AdminBundle\Entity\User $networkUsers)
    {
        $this->networkUsers->removeElement($networkUsers);
    }

    /**
     * Get networkUsers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNetworkUsers()
    {
        return $this->networkUsers;
    }

    /**
     * Set associatedUser
     *
     * @param \App\AdminBundle\Entity\User $asociatedUser
     * @return User
     */
    public function setAssociatedUser(\App\AdminBundle\Entity\User $associatedUser = null)
    {
        $this->associatedUser = $associatedUser;

        return $this;
    }

    /**
     * Get associatedUser
     *
     * @return \App\AdminBundle\Entity\User
     */
    public function getAssociatedUser()
    {
        return $this->associatedUser;
    }

    /**
     * @return \App\AdminBundle\Entity\BenefitTable
     */
    public function getDirectBenefitTable()
    {
        return $this->directBenefitTable;
    }

    /**
     * @param \App\AdminBundle\Entity\BenefitTable $directBenefitTable
     * @return User
     */
    public function setDirectBenefitTable($directBenefitTable)
    {
        $this->directBenefitTable = $directBenefitTable;
        return $this;
    }

    /**
     * @return \App\AdminBundle\Entity\BenefitTable
     */
    public function getIndirectBenefitTable()
    {
        return $this->indirectBenefitTable;
    }

    /**
     * @param \App\AdminBundle\Entity\BenefitTable $indirectBenefitTable
     * @return User
     */
    public function setIndirectBenefitTable($indirectBenefitTable)
    {
        $this->indirectBenefitTable = $indirectBenefitTable;
        return $this;
    }

    /**
     * Add notifications
     *
     * @param \App\AdminBundle\Entity\Notification $notification
     * @return User
     */
    public function addNotification(\App\AdminBundle\Entity\Notification $notification)
    {
        $this->notifications[] = $notification;

        return $this;
    }

    /**
     * Remove notification
     *
     * @param \App\AdminBundle\Entity\Notification $notification
     */
    public function removeNotification(\App\AdminBundle\Entity\Notification $notification)
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
     * Add product
     *
     * @param \App\AdminBundle\Entity\Product $product
     * @return User
     */
    public function addProduct(\App\AdminBundle\Entity\Product $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \App\AdminBundle\Entity\Product $product
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
     * Add transaction
     *
     * @param \App\AdminBundle\Entity\Transaction $transaction
     * @return User
     */
    public function addTransaction(\App\AdminBundle\Entity\Transaction $transaction)
    {
        $this->transactions[] = $transaction;

        return $this;
    }

    /**
     * Remove transaction
     *
     * @param \App\AdminBundle\Entity\Transaction $transaction
     */
    public function removeTansaction(\App\AdminBundle\Entity\Transaction $transaction)
    {
        $this->transactions->removeElement($transaction);
    }

    /**
     * Get transactions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTransactions()
    {
        return $this->transactions;
    }

    /**
     * Add userModule
     *
     * @param \App\AdminBundle\Entity\UserModule $userModule
     * @return User
     */
    public function addUserModule(\App\AdminBundle\Entity\UserModule $userModule)
    {
        $this->userModule[] = $userModule;

        return $this;
    }

    /**
     * Remove userModule
     *
     * @param \App\AdminBundle\Entity\UserModule $userModule
     */
    public function removeUserModule(\App\AdminBundle\Entity\UserModule $userModule)
    {
        $this->userModule->removeElement($userModule);
    }

    /**
     * Get userModules
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserModules()
    {
        return $this->userModule;
    }

    /**
     * Checks whether the user's account has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw an AccountExpiredException and prevent login.
     *
     * @return bool true if the user's account is non expired, false otherwise
     *
     * @see AccountExpiredException
     */
    public function isAccountNonExpired()
    {
        // TODO: Implement isAccountNonExpired() method.
        return true;
    }

    /**
     * Checks whether the user is locked.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a LockedException and prevent login.
     *
     * @return bool true if the user is not locked, false otherwise
     *
     * @see LockedException
     */
    public function isAccountNonLocked()
    {
        // TODO: Implement isAccountNonLocked() method.
        return true;
    }

    /**
     * Checks whether the user's credentials (password) has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a CredentialsExpiredException and prevent login.
     *
     * @return bool true if the user's credentials are non expired, false otherwise
     *
     * @see CredentialsExpiredException
     */
    public function isCredentialsNonExpired()
    {
        // TODO: Implement isCredentialsNonExpired() method.
        return true;
    }

    /**
     * Checks whether the user is enabled.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a DisabledException and prevent login.
     *
     * @return bool true if the user is enabled, false otherwise
     *
     * @see DisabledException
     */
    public function isEnabled()
    {
        return $this->active;
    }

    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
        ));
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            ) = unserialize($serialized);
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return Role[] The user roles
     */
    public function getRoles()
    {
        return array($this->getRole()->getRole());
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birsday
     * @return User
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }

    /**
     * get about
     * @return text
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * set about
     * @param text $about
     * @return User
     */
    public function setAbout($about)
    {
        $this->about = $about;
    }

    /**
     * Add notificationtype
     *
     * @param \App\AdminBundle\Entity\NotificationType $notificationtype
     * @return User
     */
    public function addNotificationType(\App\AdminBundle\Entity\NotificationType $notificationtype)
    {
        $this->notificationtypes[] = $notificationtype;

        return $this;
    }

    /**
     * Remove notificationtype
     *
     * @param \App\AdminBundle\Entity\NotificationType $notificationtype
     */
    public function removeNotificationType(\App\AdminBundle\Entity\NotificationType $notificationtype)
    {
        $this->notificationtypes->removeElement($notificationtype);
    }

    /**
     * Get notificationtypes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNotificationTypes()
    {
        return $this->notificationtypes;
    }

    /**
     * @return \App\AdminBundle\Entity\BankAccount
     */
    public function getBankAccount()
    {
        return $this->bankAccount;
    }

    /**
     * @param \App\AdminBundle\Entity\BankAccount $bankAccount
     * @return User
     */
    public function setBankAccount($bankAccount)
    {
        $this->bankAccount = $bankAccount;
        return $this;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Remove transactions
     *
     * @param \App\AdminBundle\Entity\Transaction $transactions
     */
    public function removeTransaction(\App\AdminBundle\Entity\Transaction $transactions)
    {
        $this->transactions->removeElement($transactions);
    }

    /**
     * Get userModule
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserModule()
    {
        return $this->userModule;
    }
}
