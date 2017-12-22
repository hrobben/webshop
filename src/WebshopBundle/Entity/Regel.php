<?php

namespace WebshopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Regel
 *
 * @ORM\Table(name="regel")
 * @ORM\Entity(repositoryClass="WebshopBundle\Repository\RegelRepository")
 */
class Regel
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
     * @ORM\ManyToOne(targetEntity="WebshopBundle\Entity\Factuur")
     * @ORM\JoinColumn(name="factuurId", referencedColumnName="id")
     *
     */
    private $factuurId;

    /**
     *
     * @ORM\ManyToOne(targetEntity="WebshopBundle\Entity\Producten")
     * @ORM\JoinColumn(name="productId", referencedColumnName="id")
     *
     */
    private $productId;

    /**
     * @var int
     *
     * @ORM\Column(name="aantal", type="float", nullable=true)
     */
    private $aantal;


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
     * Set factuurId
     *
     * @param integer $factuurId
     *
     * @return Regel
     */
    public function setFactuurId($factuurId)
    {
        $this->factuurId = $factuurId;

        return $this;
    }

    /**
     * Get factuurId
     *
     * @return int
     */
    public function getFactuurId()
    {
        return $this->factuurId;
    }

    /**
     * Set productId
     *
     * @param integer $productId
     *
     * @return Regel
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;

        return $this;
    }

    /**
     * Get productId
     *
     * @return int
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * Set aantal
     *
     * @param integer $aantal
     *
     * @return Regel
     */
    public function setAantal($aantal)
    {
        $this->aantal = $aantal;

        return $this;
    }

    /**
     * Get aantal
     *
     * @return int
     */
    public function getAantal()
    {
        return $this->aantal;
    }
}

