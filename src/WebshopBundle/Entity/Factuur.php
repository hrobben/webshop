<?php

namespace WebshopBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Factuur
 *
 * @ORM\Table(name="factuur")
 * @ORM\Entity(repositoryClass="WebshopBundle\Repository\FactuurRepository")
 */
class Factuur
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
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="klantId", referencedColumnName="id")
     *
     */
    private $klantId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datum", type="datetimetz")
     */
    private $datum;

    protected $regels;

    public function __construct()
    {
        $this->regels = new ArrayCollection();
    }

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
     * Set klantId
     *
     * @param integer $klantId
     *
     * @return Factuur
     */
    public function setKlantId($klantId)
    {
        $this->klantId = $klantId;

        return $this;
    }

    /**
     * Get klantId
     *
     * @return int
     */
    public function getKlantId()
    {
        return $this->klantId;
    }

    /**
     * Set datum
     *
     * @param \DateTime $datum
     *
     * @return Factuur
     */
    public function setDatum($datum)
    {
        $this->datum = $datum;

        return $this;
    }

    /**
     * Get datum
     *
     * @return \DateTime
     */
    public function getDatum()
    {
        return $this->datum;
    }

    /**
     * @return ArrayCollection
     */
    public function getRegels()
    {
        return $this->regels;
    }

    /**
     * @param ArrayCollection $rgls
     */
    public function setRegels($regels)
    {
        $this->regels = $regels;
    }

    public function __toString()
    {
        return $this->getId().' '.$this->getKlantId();
    }
}

