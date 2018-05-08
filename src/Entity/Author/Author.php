<?php

namespace App\Entity\Author;

use App\Entity\Common\Country;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Autor
 * @ORM\Entity
 */
class Author
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $firstName;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $lastName;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=TRUE)
     */
    private $birthDate;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=TRUE)
     */
    private $deathDate;


    /**
     * @var string
     * @ORM\Column(type="text", nullable=TRUE)
     */
    private $comments;

    /**
     * @ORM\ManyToOne(targetEntity="Job")
     * @var Job
     */
    private $job;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Common\Country")
     * @var Country
     */
    private $country;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Item\Item", mappedBy="authors")
     * @var ArrayCollection Item
     */
    private $items;

    /**
     * Author constructor.
     */
    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param \DateTime $birthDate
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @return \DateTime
     */
    public function getDeathDate()
    {
        return $this->deathDate;
    }

    /**
     * @param \DateTime $deathDate
     */
    public function setDeathDate($deathDate)
    {
        $this->deathDate = $deathDate;
    }

    /**
     * @return string
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param string $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    /**
     * @return Job
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * @param Job $job
     */
    public function setJob($job)
    {
        $this->job = $job;
    }

    /**
     * @return Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param Country $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return ArrayCollection Item
     */
    public function getItems()
    {
        return $this->items;
    }

}

