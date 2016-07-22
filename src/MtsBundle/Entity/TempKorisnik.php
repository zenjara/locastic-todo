<?php

namespace MtsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TempKorisnik
 *
 * @ORM\Table(name="temp_korisnik")
 * @ORM\Entity(repositoryClass="MtsBundle\Repository\TempKorisnikRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class TempKorisnik
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="confirm_code", type="string", length=255)
     */
    private $confirmCode;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     */
    private $lastName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="registration_date", type="datetime", nullable=true)
     */
    private $registrationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_logged_in_at", type="datetime", nullable=true)
     */
    private $lastLoggedInAt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isActive", type="boolean", nullable=true)
     */
    private $isActive;


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
     * Set confirmCode
     *
     * @param string $confirmCode
     * @return TempKorisnik
     */
    public function setConfirmCode($confirmCode)
    {
        $this->confirmCode = $confirmCode;

        return $this;
    }

    /**
     * Get confirmCode
     *
     * @return string 
     */
    public function getConfirmCode()
    {
        return $this->confirmCode;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return TempKorisnik
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
     * Set password
     *
     * @param string $password
     * @return TempKorisnik
     */
    public function setPassword($password)
    {
        $this->password = $password;

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
     * Set firstName
     *
     * @param string $firstName
     * @return TempKorisnik
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return TempKorisnik
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
     * Set registrationDate
     *
     * @param \DateTime $registrationDate
     * @return TempKorisnik
     * @ORM\PrePersist
     */
    public function setRegistrationDate()
    {
        $this->registrationDate = new \DateTime();
        return $this;
    }

    /**
     * Get registrationDate
     *
     * @return \DateTime 
     */
    public function getRegistrationDate()
    {
        return $this->registrationDate;
    }

    /**
     * Set lastLoggedInAt
     *
     * @param \DateTime $lastLoggedInAt
     * @return TempKorisnik
     */
    public function setLastLoggedInAt($lastLoggedInAt)
    {
        $this->lastLoggedInAt = $lastLoggedInAt;

        return $this;
    }

    /**
     * Get lastLoggedInAt
     *
     * @return \DateTime 
     */
    public function getLastLoggedInAt()
    {
        return $this->lastLoggedInAt;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return TempKorisnik
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
}
