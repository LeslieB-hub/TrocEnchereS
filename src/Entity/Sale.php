<?php

namespace App\Entity;

use App\Repository\SaleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SaleRepository::class)
 */
class Sale
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
    private $item;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     */
    private $startDateBid;

    /**
     * @ORM\Column(type="date")
     */
    private $endDateBid;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $initialPrice;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $salePrice;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\OneToOne(targetEntity=withdrawal::class, inversedBy="sale", cascade={"persist", "remove"})
     */
    private $withdrawalPlace;

    /**
     * @ORM\ManyToOne(targetEntity=State::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $state;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="salesPublished", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $seller;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="saleWon")
     */
    private $buyerUser;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getItem(): ?string
    {
        return $this->item;
    }

    public function setItem(string $item): self
    {
        $this->item = $item;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStartdatebid(): ?\DateTimeInterface
    {
        return $this->startDateBid;
    }

    public function setStartdatebid(\DateTimeInterface $startdatebid): self
    {
        $this->startDateBid = $startdatebid;

        return $this;
    }

    public function getEndDateBid(): ?\DateTimeInterface
    {
        return $this->endDateBid;
    }

    public function setEndDateBid(\DateTimeInterface $endDateBid): self
    {
        $this->endDateBid = $endDateBid;

        return $this;
    }

    public function getInitialPrice(): ?int
    {
        return $this->initialPrice;
    }

    public function setInitialPrice(?int $initialPrice): self
    {
        $this->initialPrice = $initialPrice;

        return $this;
    }

    public function getSalePrice(): ?int
    {
        return $this->salePrice;
    }

    public function setSalePrice(?int $salePrice): self
    {
        $this->salePrice = $salePrice;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getSeller(): ?User
    {
        return $this->seller;
    }

    public function setSeller(?User $seller): self
    {
        $this->seller = $seller;

        return $this;
    }

    public function getWithdrawalPlace(): ?withdrawal
    {
        return $this->withdrawalPlace;
    }

    public function setWithdrawalPlace(?withdrawal $withdrawalPlace): self
    {
        $this->withdrawalPlace = $withdrawalPlace;

        return $this;
    }

    public function getState(): ?State
    {
        return $this->state;
    }

    public function setState(?State $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getBuyerUser(): ?User
    {
        return $this->buyerUser;
    }

    public function setBuyerUser(?User $buyerUser): self
    {
        $this->buyerUser = $buyerUser;

        return $this;
    }
}
