<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ListAmisRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ListAmisRepository::class)]
#[ApiResource]
class ListAmis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'listAmis')]
    private ?User $idUser = null;

    #[ORM\ManyToOne(inversedBy: 'listAmis')]
    private ?User $idAmis = null;

    #[ORM\Column]
    private ?bool $pending = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): static
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getIdAmis(): ?User
    {
        return $this->idAmis;
    }

    public function setIdAmis(?User $idAmis): static
    {
        $this->idAmis = $idAmis;

        return $this;
    }

    public function isPending(): ?bool
    {
        return $this->pending;
    }

    public function setPending(bool $pending): static
    {
        $this->pending = $pending;

        return $this;
    }
}
