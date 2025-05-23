<?php

namespace App\Entity;

use App\Repository\ForumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: ForumRepository::class)]
#[ApiResource]
class Forum
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_crea = null;


    #[ORM\Column(nullable: true)]
    private ?int $ordre = null;

    #[ORM\OneToMany(mappedBy: 'idForum', targetEntity: ForumCommentaire::class)]
    private Collection $forumCommentaires;

    #[ORM\ManyToOne(inversedBy: 'forum', cascade: ['persist', 'remove'])]
    private ?User $User = null;

    #[ORM\Column(nullable: true)]
    private ?int $liker = null;

    #[ORM\OneToMany(mappedBy: 'forum', targetEntity: Likeforum::class)]
    private Collection $likeforums;

    #[ORM\OneToMany(mappedBy: 'forum', targetEntity: Signalementforum::class)]
    private Collection $signalementforums;

    public function __construct()
    {
        $this->forumCommentaires = new ArrayCollection();
        $this->likeforums = new ArrayCollection();
        $this->signalementforums = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDateCrea(): ?\DateTimeInterface
    {
        return $this->date_crea;
    }

    public function setDateCrea(\DateTimeInterface $date_crea): static
    {
        $this->date_crea = $date_crea;

        return $this;
    }

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(int $ordre): static
    {
        $this->ordre = $ordre;

        return $this;
    }


    /**
     * @return Collection<int, ForumCommentaire>
     */
    public function getForumCommentaires(): Collection
    {
        return $this->forumCommentaires;
    }

    public function addForumCommentaire(ForumCommentaire $forumCommentaire): static
    {
        if (!$this->forumCommentaires->contains($forumCommentaire)) {
            $this->forumCommentaires->add($forumCommentaire);
            $forumCommentaire->setIdForum($this);
        }

        return $this;
    }

    public function removeForumCommentaire(ForumCommentaire $forumCommentaire): static
    {
        if ($this->forumCommentaires->removeElement($forumCommentaire)) {
            // set the owning side to null (unless already changed)
            if ($forumCommentaire->getIdForum() === $this) {
                $forumCommentaire->setIdForum(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): static
    {
        $this->User = $User;

        return $this;
    }

    public function getLiker(): ?int
    {
        return $this->liker;
    }

    public function setLiker(?int $liker): static
    {
        $this->liker = $liker;

        return $this;
    }

    /**
     * @return Collection<int, Likeforum>
     */
    public function getLikeforums(): Collection
    {
        return $this->likeforums;
    }

    public function addLikeforum(Likeforum $likeforum): static
    {
        if (!$this->likeforums->contains($likeforum)) {
            $this->likeforums->add($likeforum);
            $likeforum->setForum($this);
        }

        return $this;
    }

    public function removeLikeforum(Likeforum $likeforum): static
    {
        if ($this->likeforums->removeElement($likeforum)) {
            // set the owning side to null (unless already changed)
            if ($likeforum->getForum() === $this) {
                $likeforum->setForum(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Signalementforum>
     */
    public function getSignalementforums(): Collection
    {
        return $this->signalementforums;
    }

    public function addSignalementforum(Signalementforum $signalementforum): static
    {
        if (!$this->signalementforums->contains($signalementforum)) {
            $this->signalementforums->add($signalementforum);
            $signalementforum->setForum($this);
        }

        return $this;
    }

    public function removeSignalementforum(Signalementforum $signalementforum): static
    {
        if ($this->signalementforums->removeElement($signalementforum)) {
            // set the owning side to null (unless already changed)
            if ($signalementforum->getForum() === $this) {
                $signalementforum->setForum(null);
            }
        }

        return $this;
    }
}
