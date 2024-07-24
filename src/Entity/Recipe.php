<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'Le champ {{ label }} ne doit pas être vide')]
    #[Assert\Length(min:2,max:50,minMessage: 'Le champ {{ label }} doit contenir au moins {{ limit }} caractères')]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'Le champ {{ label }} ne doit pas être vide')]
    #[Assert\Length(min:2,max:50,minMessage: 'Le champ {{ label }} doit contenir au moins {{ limit }} caractères')]
    private ?string $slug = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Range(
        min: 1,
        max: 1440,
        notInRangeMessage: 'Le temps doit etre compris entre {{ min }} et {{ max }} minutes',
    )]
    private ?int $temps = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Range(
        min: 1,
        max: 50,
        notInRangeMessage: 'Le nombre doit etre compris entre {{ min }} et {{ max }}',
    )]
    private ?int $personnes = null;

    #[Assert\NotBlank(message:'Le champ {{ label }} ne doit pas être vide')]
    #[Assert\Range(
        min: 1,
        max: 5,
        notInRangeMessage: 'Le nombre doit etre compris entre {{ min }} et {{ max }}',
    )]
    #[ORM\Column(nullable: true)]
    private ?int $difficulty = null;

    #[Assert\NotBlank(message:'Le champ {{ label }} ne doit pas être vide')]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[Assert\NotBlank(message:'Le champ {{ label }} ne doit pas être vide')]
    #[Assert\Range(
        min: 1,
        max: 1000,
        notInRangeMessage: 'Le nombre doit etre compris entre {{ min }} et {{ max }} euros',
    )]
    #[ORM\Column(nullable: true)]
    private ?float $price = null;

    #[ORM\Column(nullable: true)]
    private ?bool $favorite = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, Ingredient>
     */
    #[ORM\ManyToMany(targetEntity: Ingredient::class)]
    private Collection $ingredients;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fileName = null;

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
    }

    #[ORM\PrePersist]
    public function setCreateAtValue()
    {
        $this->createdAt = new DateTimeImmutable();
    }

    #[ORM\PrePersist]
    public function setUpdateAtValue()
    {
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getTemps(): ?int
    {
        return $this->temps;
    }

    public function setTemps(?int $temps): static
    {
        $this->temps = $temps;

        return $this;
    }

    public function getPersonnes(): ?int
    {
        return $this->personnes;
    }

    public function setPersonnes(?int $personnes): static
    {
        $this->personnes = $personnes;

        return $this;
    }

    public function getDifficulty(): ?string
    {
        return $this->difficulty;
    }

    public function setDifficulty(?string $difficulty): static
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function isFavorite(): ?bool
    {
        return $this->favorite;
    }

    public function setFavorite(?bool $favorite): static
    {
        $this->favorite = $favorite;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Ingredient>
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredient $ingredient): static
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients->add($ingredient);
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): static
    {
        $this->ingredients->removeElement($ingredient);

        return $this;
    }

    public function getfileName(): ?string
    {
        return $this->fileName;
    }

    public function setfileName(?string $fileName): static
    {
        $this->fileName = $fileName;

        return $this;
    }
}
