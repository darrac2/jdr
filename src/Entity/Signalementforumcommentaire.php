<?php

namespace App\Entity;

use App\Repository\SignalementforumcommentaireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SignalementforumcommentaireRepository::class)]
class Signalementforumcommentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sujet = null;

    #[ORM\ManyToOne(inversedBy: 'forumCommentaire')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'signalementforumcommentaires')]
    private ?ForumCommentaire $forumcommentaire = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $message = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    public function setSujet(?string $sujet): static
    {
        $this->sujet = $sujet;

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

    public function getForumcommentaire(): ?ForumCommentaire
    {
        return $this->forumcommentaire;
    }

    public function setForumcommentaire(?ForumCommentaire $forumcommentaire): static
    {
        $this->forumcommentaire = $forumcommentaire;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }
}
