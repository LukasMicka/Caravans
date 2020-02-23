<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PricelistRepository")
 */
class Pricelist
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Caravan", inversedBy="pricelists")
     * @ORM\JoinColumn(nullable=false)
     */
    private $caravan;

    /**
     * @ORM\Column(type="string", length=127, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $validFrom;

    /**
     * @ORM\Column(type="datetime")
     */
    private $validTill;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="float")
     */
    private $priceVat;

    /**
     * @ORM\Column(type="string", length=127, nullable=true)
     */
    private $currency;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCaravan(): ?Caravan
    {
        return $this->caravan;
    }

    public function setCaravan(?Caravan $caravan): self
    {
        $this->caravan = $caravan;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getValidFrom(): ?\DateTimeInterface
    {
        return $this->validFrom;
    }

    public function setValidFrom(\DateTimeInterface $validFrom): self
    {
        $this->validFrom = $validFrom;

        return $this;
    }

    public function getValidTill(): ?\DateTimeInterface
    {
        return $this->validTill;
    }

    public function setValidTill(\DateTimeInterface $validTill): self
    {
        $this->validTill = $validTill;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPriceVat(): ?float
    {
        return $this->priceVat;
    }

    public function setPriceVat(float $priceVat): self
    {
        $this->priceVat = $priceVat;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(?string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }
}
