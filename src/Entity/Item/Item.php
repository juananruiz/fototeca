<?php

namespace App\Entity\Item;

use App\Entity\Author\Author;
use App\Entity\Common\Country;
use App\Entity\Image\Image;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 */
class Item
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=TRUE)
     * @var string
     */
    private $comments;

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
     * @ORM\Column(type="string", nullable=TRUE)
     * @var string
     */
    private $locality;

    /**
     * @ORM\Column(type="string", unique=TRUE)
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="string", nullable=TRUE)
     * @var string
     */
    private $province;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Image\Image", mappedBy="item")
     * @var Image[]
     */
    private $images;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Author\Author", inversedBy="items")
     * @var Author[]
     **/
    private $authors;

    /**
     * @ORM\ManyToMany(targetEntity="Serie", mappedBy="items")
     * @var Serie[]
     **/
    private $series;


    /**
     * @param ArrayCollection $images
     * @param ArrayCollection $authors
     * @param ArrayCollection $series
     */
    public function __construct(ArrayCollection $images, ArrayCollection $authors, ArrayCollection $series)
    {
        $this->images = new ArrayCollection();
        $this->authors = new ArrayCollection();
        $this->series = new ArrayCollection();
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * @return string
     */
    public function getLocality()
    {
        return $this->locality;
    }

    /**
     * @param string $locality
     */
    public function setLocality($locality)
    {
        $this->locality = $locality;
    }

    /**
     * @return string
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @param string $province
     */
    public function setProvince($province)
    {
        $this->province = $province;
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
     * @return ArrayCollection Image
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param Image $image
     */
    public function addImage(Image $image)
    {
        $this->images[] = $image;
    }

    /**
     * @return ArrayCollection Author
     */
    public function getAuthors()
    {
        return $this->authors;
    }

    /**
     * @param Author $author
     */
    public function addAuthor(Author $author)
    {
        $this->authors[] = $author;
    }

    /**
     * @return ArrayCollection Serie
     */
    public function getSeries()
    {
        return $this->series;
    }

    /**
     * @param Serie $serie
     */
    public function addSerie(Serie $serie)
    {
        $this->series[] = $serie;
    }

}