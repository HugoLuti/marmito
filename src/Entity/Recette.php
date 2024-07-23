<?php

namespace App\Entity;

use App\Repository\RecetteRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\TextType;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RecetteRepository::class)]
#[HasLifecycleCallbacks]
class Recette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\NotBlank(message: "Le champs {{ label }} ne doit pas etre vide")]
    #[Assert\Length(min: 2, max: 50, minMessage: 'Le nom de la {{ label }} doit faire minimum {{ limit }} caractères', maxMessage: 'Le nom de la {{ label }} ne peux pas faire plus de {{ limit }} caractères')]
    private ?string $nom = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\NotBlank(message: 'Le champs {{ label }} ne doit pas etre vide')]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'La longueur du {{ label }} doit faire minimum {{ limit }} caractères',
        maxMessage: 'La longueur du {{ label }} ne peux pas faire plus de {{ limit }} caractères'
    )]
    private ?string $slug = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank(message: 'Le champs {{ label }} ne doit pas etre vide')]
    #[Assert\Range(min: 1, max: 1440, notInRangeMessage: 'Le {{ label }} de la recette doit faire minimum {{ min }} minutes et maximum {{ max }} minutes')]
    #[Assert\Positive()]
    private ?int $temps = null;

    #[ORM\Column]
    #[Assert\LessThan(50)]
    #[Assert\NotBlank(message: 'Veuillez indiqué un nombre')]
    private ?int $nbPersonne = null;

    #[ORM\Column]
    #[Assert\Range(min: 1, max: 5)]
    #[Assert\NotBlank(message: 'Veuillez selectionner le niveau de difficulté')]
    private ?int $difficulte = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Veuillez remplir la {{ label }}')]
    private ?TextType $description = null;

    #[ORM\Column]
    #[Assert\Range(min: 0, max: 1000, notInRangeMessage: 'Veuillez indiqué un prix entre {{ min }} euro et {{ max }} euro')]
    #[Assert\NotBlank(message: 'Veuillez indiqué un prix')]
    private ?int $prix = null;

    #[ORM\Column]
    private ?bool $favorie = null;

    #[ORM\PrePersist]
    public function setdateCreationAt()
    {
        $this->dateCreation = new DateTimeImmutable();
    }

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dateCreation = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dateMiseaJour = null;

    /**
     * @var Collection<int, Ingredient>
     */
    #[ORM\ManyToMany(targetEntity: Ingredient::class)]
    private Collection $ingredients;

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

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

    public function getTemps(): ?string
    {
        return $this->temps;
    }

    public function setTemps(string $temps): static
    {
        $this->temps = $temps;

        return $this;
    }

    public function getNbPersonne(): ?int
    {
        return $this->nbPersonne;
    }

    public function setNbPersonne(int $nbPersonne): static
    {
        $this->nbPersonne = $nbPersonne;

        return $this;
    }

    public function getDifficulte(): ?int
    {
        return $this->difficulte;
    }

    public function setDifficulte(int $difficulte): static
    {
        $this->difficulte = $difficulte;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function isFavorie(): ?bool
    {
        return $this->favorie;
    }

    public function setFavorie(bool $favorie): static
    {
        $this->favorie = $favorie;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeImmutable
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeImmutable $dateCreation): static
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getDateMiseaJour(): ?\DateTimeImmutable
    {
        return $this->dateMiseaJour;
    }

    public function setDateMiseaJour(\DateTimeImmutable $dateMiseaJour): static
    {
        $this->dateMiseaJour = $dateMiseaJour;

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
}
