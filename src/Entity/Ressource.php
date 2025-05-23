<?php

namespace App\Entity;

use App\Repository\RessourceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: RessourceRepository::class)]
#[ApiResource]
class Ressource
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fichier = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\ManyToOne(cascade: ['persist', 'remove'])]
    private ?Category $category = null;

    #[ORM\Column(nullable: false)]
    private ?int $status = null;

    #[ORM\Column]
    private ?bool $private = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_publication = null;

    #[ORM\ManyToOne(inversedBy: 'ressource')]
    private ?User $user = null;

    #[ORM\Column(nullable: true)]
    private ?int $comptliker = null;

    #[ORM\OneToMany(mappedBy: 'ressource', targetEntity: SignalementRessource::class)]
    private Collection $signalementRessources;


    #[ORM\OneToMany(mappedBy: 'ressource', targetEntity: Liker::class)]
    private Collection $Liker;

    #[ORM\OneToMany(mappedBy: 'Ressource', targetEntity: Liker::class)]
    private Collection $likers;

    public function __construct()
    {
        $this->signalementRessources = new ArrayCollection();
        $this->Liker = new ArrayCollection();
        $this->likers = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getFichier(): ?string
    {
        return $this->fichier;
    }

    public function setFichier(string $fichier): static
    {
        $this->fichier = $fichier;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getCategory(): ?category
    {
        return $this->category;
    }

    public function setCategory(?category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getPrivate(): ?int
    {
        return $this->private;
    }

    public function setPrivate(int $private): static
    {
        $this->private = $private;

        return $this;
    }

    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->date_publication;
    }

    public function setDatePublication(\DateTimeInterface $date_publication): static
    {
        $this->date_publication = $date_publication;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getComptliker(): ?int
    {
        return $this->comptliker;
    }

    public function setComptliker(?int $comptliker): static
    {
        $this->comptliker = $comptliker;

        return $this;
    }

    public function isPrivate(): ?bool
    {
        return $this->private;
    }

    /**
     * @return Collection<int, SignalementRessource>
     */
    public function getSignalementRessources(): Collection
    {
        return $this->signalementRessources;
    }

    public function addSignalementRessource(SignalementRessource $signalementRessource): static
    {
        if (!$this->signalementRessources->contains($signalementRessource)) {
            $this->signalementRessources->add($signalementRessource);
            $signalementRessource->setRessource($this);
        }

        return $this;
    }

    public function removeSignalementRessource(SignalementRessource $signalementRessource): static
    {
        if ($this->signalementRessources->removeElement($signalementRessource)) {
            // set the owning side to null (unless already changed)
            if ($signalementRessource->getRessource() === $this) {
                $signalementRessource->setRessource(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection<int, Liker>
     */
    public function getLiker(): Collection
    {
        return $this->Liker;
    }

    /**
     * @return Collection<int, Liker>
     */
    public function getLikers(): Collection
    {
        return $this->likers;
    }

    public function addLiker(Liker $liker): static
    {
        if (!$this->likers->contains($liker)) {
            $this->likers->add($liker);
            $liker->setRessource($this);
        }

        return $this;
    }

    public function removeLiker(Liker $liker): static
    {
        if ($this->likers->removeElement($liker)) {
            // set the owning side to null (unless already changed)
            if ($liker->getRessource() === $this) {
                $liker->setRessource(null);
            }
        }

        return $this;
    }
}
