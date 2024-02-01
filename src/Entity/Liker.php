<?php

namespace App\Entity;

use App\Repository\LikerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LikerRepository::class)]
class Liker
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $liker = null;

    #[ORM\ManyToOne(inversedBy: 'likers')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'likers')]
    private ?Ressource $ressource = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isLiker(): ?bool
    {
        return $this->liker;
    }

    public function setLiker(bool $liker): static
    {
        $this->liker = $liker;

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

    public function getRessource(): ?Ressource
    {
        return $this->ressource;
    }

    public function setRessource(?Ressource $ressource): static
    {
        $this->ressource = $ressource;

        return $this;
    }
}
