<?php

namespace WebshopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Producten
 *
 * @ORM\Table(name="producten")
 * @ORM\Entity(repositoryClass="WebshopBundle\Repository\ProductenRepository")
 */
class Producten
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
     * @ORM\Column(name="code", type="string", length=25, unique=true)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="omschrijving", type="string", length=255)
     */
    private $omschrijving;

    /**
     * @var float
     *
     * @ORM\Column(name="prijs", type="float", nullable=true)
     */
    private $prijs;

    /**
     * @var string
     *
     * @ORM\Column(name="imagepath", type="string", length=255, nullable=true)
     *
     */
    private $imagepath;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Producten
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set omschrijving
     *
     * @param string $omschrijving
     *
     * @return Producten
     */
    public function setOmschrijving($omschrijving)
    {
        $this->omschrijving = $omschrijving;

        return $this;
    }

    /**
     * Get omschrijving
     *
     * @return string
     */
    public function getOmschrijving()
    {
        return $this->omschrijving;
    }

    /**
     * Set prijs
     *
     * @param float $prijs
     *
     * @return Producten
     */
    public function setPrijs($prijs)
    {
        $this->prijs = $prijs;

        return $this;
    }

    /**
     * Get prijs
     *
     * @return float
     */
    public function getPrijs()
    {
        return $this->prijs;
    }

    /**
     * Set imagepath
     *
     * @param string $imagepath
     *
     * @return Producten
     */
    public function setImagepath($imagepath)
    {
        $this->imagepath = $imagepath;

        return $this;
    }

    /**
     * Get imagepath
     *
     * @return string
     */
    public function getImagepath()
    {
        return $this->imagepath;
    }

    public function __toString()
    {
        return $this->getOmschrijving();
    }
}
