<?php

namespace App\Entity\Image;

use App\Entity\Author\Author;
use App\Entity\Item\Item;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Image
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
    private $comment;

    /**
     * @ORM\Column(type="string", nullable=TRUE)
     * @var string
     */
    private $conservation;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string")
     */
    private $fileName;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item\Item", inversedBy="images")
     */
    private $item;

    /**
     * @ORM\Column(type="string", nullable=TRUE)
     * @var string
     */
    private $location;

    /**
     * @ORM\ManyToOne(targetEntity="Medium")
     */
    private $medium;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Author\Author")
     * @var Author
     */
    private $author;

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
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComments($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return string
     */
    public function getConservation()
    {
        return $this->conservation;
    }

    /**
     * @param string $conservation
     */
    public function setConservation($conservation)
    {
        $this->conservation = $conservation;
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
     * @return Item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @param Item $item
     */
    public function setItem($item)
    {
        $this->item = $item;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return mixed
     */
    public function getMedium()
    {
        return $this->medium;
    }

    /**
     * @param Medium $medium
     */
    public function setMedium($medium)
    {
        $this->medium = $medium;
    }

    /**
     * @return Author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param Author $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

}
