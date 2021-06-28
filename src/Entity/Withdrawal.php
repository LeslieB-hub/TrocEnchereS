<?php

namespace App\Entity;

use App\Repository\WithdrawalRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WithdrawalRepository::class)
 */
class Withdrawal
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $postcode;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $city;

    /**
     * @ORM\OneToOne(targetEntity=Sale::class, mappedBy="withdrawal", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="saleNumber", referencedColumnName="id", unique=true)
     */
    private $sale;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function setPostcode(string $postcode): self
    {
        $this->postcode = $postcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getSale(): ?Sale
    {
        return $this->sale;
    }

    public function setSale(?Sale $sale): self
    {
        // unset the owning side of the relation if necessary
        if ($sale === null && $this->sale !== null) {
            $this->sale->setWithdrawal(null);
        }

        // set the owning side of the relation if necessary
        if ($sale !== null && $sale->getWithdrawalPlace() !== $this) {
            $sale->setWithdrawalPlace($this);
        }

        $this->sale = $sale;

        return $this;
    }
}
