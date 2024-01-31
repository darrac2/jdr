<?php

namespace App\Entity;

use App\Repository\ForumCommentaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: ForumCommentaireRepository::class)]
#[ApiResource]
class ForumCommentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_creation = null;


    #[ORM\ManyToOne(inversedBy: 'forumCommentaires')]
    private ?Forum $idForum = null;

    #[ORM\ManyToOne]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'forumcommentaire', targetEntity: Signalementforumcommentaire::class)]
    private Collection $signalementforumcommentaires;

    public function __construct()
    {
        $this->signalementforumcommentaires = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }
    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): static
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getIdForum(): ?Forum
    {
        return $this->idForum;
    }

    public function setIdForum(?Forum $idForum): static
    {
        $this->idForum = $idForum;

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

    /**
     * @return Collection<int, Signalementforumcommentaire>
     */
    public function getSignalementforumcommentaires(): Collection
    {
        return $this->signalementforumcommentaires;
    }

    public function addSignalementforumcommentaire(Signalementforumcommentaire $signalementforumcommentaire): static
    {
        if (!$this->signalementforumcommentaires->contains($signalementforumcommentaire)) {
            $this->signalementforumcommentaires->add($signalementforumcommentaire);
            $signalementforumcommentaire->setForumcommentaire($this);
        }

        return $this;
    }

    public function removeSignalementforumcommentaire(Signalementforumcommentaire $signalementforumcommentaire): static
    {
        if ($this->signalementforumcommentaires->removeElement($signalementforumcommentaire)) {
            // set the owning side to null (unless already changed)
            if ($signalementforumcommentaire->getForumcommentaire() === $this) {
                $signalementforumcommentaire->setForumcommentaire(null);
            }
        }

        return $this;
    }
}
