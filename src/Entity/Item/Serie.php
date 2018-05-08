<?php

namespace App\Entity\Item;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 */
class Serie
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private $isJewel;

    /**
     * @ORM\ManyToMany(targetEntity="Item", inversedBy="series")
     * @var ArrayCollection Item
     */
    private $items;


    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * @return mixed
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getIsJewel()
    {
        return $this->isJewel;
    }

    /**
     * @param int $isJewel
     */
    public function setIsJewel($isJewel)
    {
        $this->isJewel = $isJewel;
    }

    /**
     * @return ArrayCollection Item
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param Item $item
     */
    public function addItem(Item $item)
    {
        $this->items[] = $item;
    }

}
