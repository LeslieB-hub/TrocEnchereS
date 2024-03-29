<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Entrer un pseudo, s'il vous plaît!")
     * @Assert\Regex(pattern="/^[a-zA-Z0-9]+$/", message="Ce pseudo n'est pas valide!")
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Assert\NotBlank(message="Entrer votre prénom, s'il vous plaît!")
     * @Assert\Length(min = 2, max = 50,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters")
     * @ORM\Column(type="string", length=50)
     */
    private $firstname;

    /**
     * @Assert\NotBlank(message="Entrer votre nom, s'il vous plaît!")
     * @Assert\Length(min = 2, max = 50,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters")
     * @ORM\Column(type="string", length=50)
     */
    private $lastname;

    /**
     * @Assert\NotBlank(message="Entrer votre email, s'il vous plaît!")
     * @Assert\Email(message="L'email {{ value }}, n'est pas valide!")
     * @ORM\Column(type="string", length=30, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $postcode;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $balance;

    /**
     * @ORM\OneToMany(targetEntity=Sale::class, mappedBy="seller", orphanRemoval=true)
     */
    private $salesPublished;

    /**
     * @ORM\OneToMany(targetEntity=Sale::class, mappedBy="buyerUser")
     */
    private $saleWon;

    public function __construct()
    {
        $this->salesPublished = new ArrayCollection();
        $this->saleWon = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function setPostcode(?string $postcode): self
    {
        $this->postcode = $postcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getBalance(): ?int
    {
        return $this->balance;
    }

    public function setBalance(?int $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    /**
     * @return Collection|Sale[]
     */
    public function getSalesPublished(): Collection
    {
        return $this->salesPublished;
    }

    public function addSalesPublished(Sale $salesPublished): self
    {
        if (!$this->salesPublished->contains($salesPublished)) {
            $this->salesPublished[] = $salesPublished;
            $salesPublished->setSeller($this);
        }

        return $this;
    }

    public function removeSalesPublished(Sale $salesPublished): self
    {
        if ($this->salesPublished->removeElement($salesPublished)) {
            // set the owning side to null (unless already changed)
            if ($salesPublished->getSeller() === $this) {
                $salesPublished->setSeller(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Sale[]
     */
    public function getSaleWon(): Collection
    {
        return $this->saleWon;
    }

    public function addSaleWon(Sale $saleWon): self
    {
        if (!$this->saleWon->contains($saleWon)) {
            $this->saleWon[] = $saleWon;
            $saleWon->setBuyerUser($this);
        }

        return $this;
    }

    public function removeSaleWon(Sale $saleWon): self
    {
        if ($this->saleWon->removeElement($saleWon)) {
            // set the owning side to null (unless already changed)
            if ($saleWon->getBuyerUser() === $this) {
                $saleWon->setBuyerUser(null);
            }
        }

        return $this;
    }
}
