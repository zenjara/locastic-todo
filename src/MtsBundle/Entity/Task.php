<?php

namespace MtsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Task
 *
 * @ORM\Table(name="task")
 * @ORM\Entity(repositoryClass="MtsBundle\Repository\TaskRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Task
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
     * @var string
     *
     * @ORM\Column(name="priority", type="string", length=255)
     */
    private $priority;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deadline", type="datetime",nullable=true)
     */
    private $deadline;


    /**
     * @var boolean
     *
     * @ORM\Column(name="isCompleted", type="boolean",nullable=true)
     */
    private $isCompleted;

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
     * @return Task
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
     * Set priority
     *
     * @param string $priority
     * @return Task
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return string
     */
    public function getPriority()
    {
        return $this->priority;
    }

    

    /**
     * @ORM\ManyToOne(targetEntity="Tlist", inversedBy="tasks")
     * @ORM\JoinColumn(name="tlist_id", referencedColumnName="id")
     */
    private $tlist;



    /**
     * Set tlist
     *
     * @param \MtsBundle\Entity\Tlist $tlist
     * @return Task
     */
    public function setTlist(\MtsBundle\Entity\Tlist $tlist = null)
    {
        $this->tlist = $tlist;

        return $this;
    }

    /**
     * Get tlist
     *
     * @return \MtsBundle\Entity\Tlist 
     */
    public function getTlist()
    {
        return $this->tlist;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->isCompleted = false;
    }

    /**
     * Set isCompleted
     *
     * @param boolean $isCompleted
     * @return Task
     */
    public function setIsCompleted($isCompleted)
    {
        $this->isCompleted = $isCompleted;

        return $this;
    }

    /**
     * Get isCompleted
     *
     * @return boolean 
     */
    public function getIsCompleted()
    {
        return $this->isCompleted;
    }

    /**
     * Set deadline
     *
     * @param \DateTime $deadline
     * @return Task
     */
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;

        return $this;
    }

    /**
     * Get deadline
     *
     * @return \DateTime 
     */
    public function getDeadline()
    {
        return $this->deadline;
    }
}
