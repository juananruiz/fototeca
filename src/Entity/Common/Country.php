<?php

namespace App\Entity\Common;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 **/
class Country
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
    private $nameEn;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $nameEs;

    /**
     * Gentilicio: denominación correspondiente a la nacionalidad: española, francesa, japonesa
     * @ORM\Column(type="string", nullable=TRUE)
     * @var string
     */
    private $demonymEn;

    /**
     * Gentilicio: denominación correspondiente a la nacionalidad: española, francesa, japonesa
     * @ORM\Column(type="string", nullable=TRUE)
     * @var string
     */
    private $demonymEs;

    /**
     * @ORM\Column(type="string", length=2)
     * @var string
     */
    private $iso;

    /**
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $phoneCode;

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
    public function getNameEn()
    {
        return $this->nameEn;
    }

    /**
     * @param string $name
     */
    public function setNameEn($name)
    {
        $this->nameEn = $name;
    }

    /**
     * @return string
     */
    public function getNameEs()
    {
        return $this->nameEs;
    }

    /**
     * @param string $name
     */
    public function setNameEs($name)
    {
        $this->nameEs = $name;
    }

    /**
     * @return string
     */
    public function getDemonymEs()
    {
        return $this->demonymEs;
    }

    /**
     * @param string $demonym
     */
    public function setDemonymEs($demonym)
    {
        $this->demonymEs = $demonym;
    }

    /**
     * @return string
     */
    public function getDemonymEn()
    {
        return $this->demonymEn;
    }

    /**
     * @param string $demonym
     */
    public function setDemonymEn($demonym)
    {
        $this->demonymEn = $demonym;
    }

    /**
     * @return string
     */
    public function getIso()
    {
        return $this->iso;
    }

    /**
     * @param string $iso
     */
    public function setIso($iso)
    {
        $this->iso = $iso;
    }

    /**
     * @return int
     */
    public function getPhoneCode()
    {
        return $this->phoneCode;
    }

    /**
     * @param int $phoneCode
     */
    public function setPhoneCode($phoneCode)
    {
        $this->phoneCode = $phoneCode;
    }


}