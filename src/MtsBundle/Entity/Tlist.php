<?php

namespace MtsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tlist
 *
 * @ORM\Table(name="tlist")
 * @ORM\Entity(repositoryClass="MtsBundle\Repository\TlistRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Tlist
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime",nullable=true)
     */
    private $createdAt;

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
     * @return Tlist
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
     * @ORM\ManyToOne(targetEntity="Korisnik", inversedBy="tlists")
     * @ORM\JoinColumn(name="korisnik_id", referencedColumnName="id", nullable=false)
     */
    protected $korisnik;

    /**
     * Set korisnik
     *
     * @param \MtsBundle\Entity\Korisnik $korisnik
     * @return Tlist
     */
    public function setKorisnik(\MtsBundle\Entity\Korisnik $korisnik)
    {
        $this->korisnik = $korisnik;

        return $this;
    }

    /**
     * Get korisnik
     *
     * @return \MtsBundle\Entity\Korisnik 
     */
    public function getKorisnik()
    {
        return $this->korisnik;
    }

    /** @ORM\OneToMany(targetEntity="Task", mappedBy="tlist") */
    protected $tasks;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tasks = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add tasks
     *
     * @param \MtsBundle\Entity\Task $tasks
     * @return Tlist
     */
    public function addTask(\MtsBundle\Entity\Task $tasks)
    {
        $this->tasks[] = $tasks;

        return $this;
    }

    /**
     * Remove tasks
     *
     * @param \MtsBundle\Entity\Task $tasks
     */
    public function removeTask(\MtsBundle\Entity\Task $tasks)
    {
        $this->tasks->removeElement($tasks);
    }

    /**
     * Get tasks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Tlist
     * @ORM\PrePersist
     */
    public function setCreatedAt()
    {
        $this->createdAt =  new \DateTime();

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
