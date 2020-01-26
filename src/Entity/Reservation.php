<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 */
class Reservation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Caravan", inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $caravan;

    /**
     * @ORM\Column(type="string", length=127)
     * @Assert\NotBlank(message="Pro rezervaci je nutné uvést Vaše jméno.")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Pro rezervaci je nutné uvést Vaše příjmení.")
     */
    private $surname;

    /**
     * @ORM\Column(type="string", length=127)
     * @Assert\NotBlank(message="Pro rezervaci je nutné uvést Vaše telefonní číslo.")
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=127)
     * @Assert\NotBlank(message="Pro rezervaci je nutné uvést Vaši platnou emailovou adresu.")
     * @Assert\Email(message="Pro rezervaci je nutné uvést Vaši platnou emailovou adresu.")
     */
    private $email;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(message="Pro rezervaci je nutné uvést datum začátku.")
     * @Assert\DateTime(message="Pro rezervaci je nutné uvést platné datum začátku.") 
     */
    private $reservationFrom;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(message="Pro rezervaci je nutné uvést datum ukončení.")
     * @Assert\DateTime(message="Pro rezervaci je nutné uvést platné datum ukončení.")
     */
    private $reservationTo;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $customerNote;

    public function getId(): int
    {
        return $this->id;
    }

    public function getReservationFrom(): \DateTimeInterface
    {
        return $this->reservationFrom;
    }

    public function setReservationFrom($reservationFrom): self
    {
        $this->reservationFrom = $reservationFrom;

        return $this;
    }

    public function getReservationTo(): \DateTimeInterface
    {
        return $this->reservationTo;
    }

    public function setReservationTo($reservationTo): self
    {
        $this->reservationTo = $reservationTo;

        return $this;
    }

    public function getCaravan(): Caravan
    {
        return $this->caravan;
    }

    public function setCaravan(Caravan $caravan): self
    {
        $this->caravan = $caravan;

        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName($firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname($surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone($phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCustomerNote(): ?string
    {
        return $this->customerNote;
    }

    public function setCustomerNote(?string $customerNote): self
    {
        $this->customerNote = $customerNote;

        return $this;
    }
}
