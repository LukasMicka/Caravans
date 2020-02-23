<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CaravanRepository")
 */
class Caravan
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=127)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=127, nullable=true)
     */
    private $color;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="caravan")
     */
    private $reservations;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Pricelist", mappedBy="caravan")
     */
    private $pricelists;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->pricelists = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setCaravan($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->contains($reservation)) {
            $this->reservations->removeElement($reservation);
            // set the owning side to null (unless already changed)
            if ($reservation->getCaravan() === $this) {
                $reservation->setCaravan(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Pricelist[]
     */
    public function getPricelists(): Collection
    {
        return $this->pricelists;
    }

    public function addPricelist(Pricelist $pricelist): self
    {
        if (!$this->pricelists->contains($pricelist)) {
            $this->pricelists[] = $pricelist;
            $pricelist->setCaravan($this);
        }

        return $this;
    }

    public function removePricelist(Pricelist $pricelist): self
    {
        if ($this->pricelists->contains($pricelist)) {
            $this->pricelists->removeElement($pricelist);
            // set the owning side to null (unless already changed)
            if ($pricelist->getCaravan() === $this) {
                $pricelist->setCaravan(null);
            }
        }

        return $this;
    }
}
