<?php

namespace App\Entity;

use App\Repository\SignalementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: SignalementRepository::class)]
#[ApiResource]
class Signalement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $nb = null;

    #[ORM\ManyToMany(targetEntity: Ressource::class, inversedBy: 'signalements')]
    private Collection $ressource;

    public function __construct()
    {
        $this->ressource = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNb(): ?int
    {
        return $this->nb;
    }

    public function setNb(?int $nb): static
    {
        $this->nb = $nb;

        return $this;
    }

    /**
     * @return Collection<int, Ressource>
     */
    public function getRessource(): Collection
    {
        return $this->ressource;
    }

    public function addRessource(Ressource $ressource): static
    {
        if (!$this->ressource->contains($ressource)) {
            $this->ressource->add($ressource);
        }

        return $this;
    }

    public function removeRessource(Ressource $ressource): static
    {
        $this->ressource->removeElement($ressource);

        return $this;
    }
}
