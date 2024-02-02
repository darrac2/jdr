<?php

namespace App\Entity;

use App\Repository\LikeforumRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LikeforumRepository::class)]
class Likeforum
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $liker = null;

    #[ORM\ManyToOne(inversedBy: 'likeforums')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'likeforums')]
    private ?Forum $forum = null;

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

    public function getForum(): ?Forum
    {
        return $this->forum;
    }

    public function setForum(?Forum $forum): static
    {
        $this->forum = $forum;

        return $this;
    }
}
