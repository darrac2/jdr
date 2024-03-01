<?php

namespace App\Entity;

use App\Repository\LikerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    private ?Ressource $Ressource = null;


    public function __construct()
    {
        
    }

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

    public function getLiker(): ?int
    {
        return $this->liker;
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
        return $this->Ressource;
    }

    public function setRessource(?Ressource $Ressource): static
    {
        $this->Ressource = $Ressource;

        return $this;
    }

}
