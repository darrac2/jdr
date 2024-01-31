<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $profil_image = null;

    #[ORM\Column(length: 255)]
    private ?string $pseudo = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_creation = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\OneToOne(mappedBy: 'User')]
    private ?Forum $forum = null;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Ressource $ressource = null;

    #[ORM\OneToMany(mappedBy: 'idUser', targetEntity: ListAmis::class)]
    private Collection $listAmis;

    #[ORM\Column(nullable: true)]
    private ?int $numAmis = null;

    #[ORM\OneToMany(mappedBy: 'userfirst', targetEntity: Conversation::class)]
    private Collection $conversations;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Actualite::class)]
    private Collection $actualites;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: SignalementRessource::class)]
    private Collection $signalementRessources;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Signalementforum::class)]
    private Collection $Forum;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Signalementforumcommentaire::class)]
    private Collection $forumCommentaire;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Liker::class)]
    private Collection $likers;



    public function __construct()
    {
        $this->listAmis = new ArrayCollection();
        $this->conversations = new ArrayCollection();
        $this->actualites = new ArrayCollection();
        $this->signalementRessources = new ArrayCollection();
        $this->Forum = new ArrayCollection();
        $this->forumCommentaire = new ArrayCollection();
        $this->likers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getProfilImage(): ?string
    {
        return $this->profil_image;
    }

    public function setProfilImage(?string $profil_image): static
    {
        $this->profil_image = $profil_image;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getForum(): ?Forum
    {
        return $this->forum;
    }

    public function setForum(?Forum $forum): static
    {
        // unset the owning side of the relation if necessary
        if ($forum === null && $this->forum !== null) {
            $this->forum->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($forum !== null && $forum->getUser() !== $this) {
            $forum->setUser($this);
        }

        $this->forum = $forum;

        return $this;
    }

    public function getRessource(): ?Ressource
    {
        return $this->ressource;
    }

    public function setRessource(?Ressource $ressource): static
    {
        // unset the owning side of the relation if necessary
        if ($ressource === null && $this->ressource !== null) {
            $this->ressource->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($ressource !== null && $ressource->getUser() !== $this) {
            $ressource->setUser($this);
        }

        $this->ressource = $ressource;

        return $this;
    }

    /**
     * @return Collection<int, ListAmis>
     */
    public function getListAmis(): Collection
    {
        return $this->listAmis;
    }

    public function addListAmi(ListAmis $listAmi): static
    {
        if (!$this->listAmis->contains($listAmi)) {
            $this->listAmis->add($listAmi);
            $listAmi->setIdUser($this);
        }

        return $this;
    }

    public function removeListAmi(ListAmis $listAmi): static
    {
        if ($this->listAmis->removeElement($listAmi)) {
            // set the owning side to null (unless already changed)
            if ($listAmi->getIdUser() === $this) {
                $listAmi->setIdUser(null);
            }
        }

        return $this;
    }

    public function getNumAmis(): ?int
    {
        return $this->numAmis;
    }

    public function setNumAmis(?int $numAmis): static
    {
        $this->numAmis = $numAmis;

        return $this;
    }

    /**
     * @return Collection<int, Conversation>
     */
    public function getConversations(): Collection
    {
        return $this->conversations;
    }

    public function addConversation(Conversation $conversation): static
    {
        if (!$this->conversations->contains($conversation)) {
            $this->conversations->add($conversation);
            $conversation->setUserfirst($this);
        }

        return $this;
    }

    public function removeConversation(Conversation $conversation): static
    {
        if ($this->conversations->removeElement($conversation)) {
            // set the owning side to null (unless already changed)
            if ($conversation->getUserfirst() === $this) {
                $conversation->setUserfirst(null);
            }
        }

        return $this;
    }

    public function isIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    /**
     * @return Collection<int, Actualite>
     */
    public function getActualites(): Collection
    {
        return $this->actualites;
    }

    public function addActualite(Actualite $actualite): static
    {
        if (!$this->actualites->contains($actualite)) {
            $this->actualites->add($actualite);
            $actualite->setUser($this);
        }

        return $this;
    }

    public function removeActualite(Actualite $actualite): static
    {
        if ($this->actualites->removeElement($actualite)) {
            // set the owning side to null (unless already changed)
            if ($actualite->getUser() === $this) {
                $actualite->setUser(null);
            }
        }

        return $this;
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
            $signalementRessource->setUser($this);
        }

        return $this;
    }

    public function removeSignalementRessource(SignalementRessource $signalementRessource): static
    {
        if ($this->signalementRessources->removeElement($signalementRessource)) {
            // set the owning side to null (unless already changed)
            if ($signalementRessource->getUser() === $this) {
                $signalementRessource->setUser(null);
            }
        }

        return $this;
    }

    public function addForum(Signalementforum $forum): static
    {
        if (!$this->Forum->contains($forum)) {
            $this->Forum->add($forum);
            $forum->setUser($this);
        }

        return $this;
    }

    public function removeForum(Signalementforum $forum): static
    {
        if ($this->Forum->removeElement($forum)) {
            // set the owning side to null (unless already changed)
            if ($forum->getUser() === $this) {
                $forum->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Signalementforumcommentaire>
     */
    public function getForumCommentaire(): Collection
    {
        return $this->forumCommentaire;
    }

    public function addForumCommentaire(Signalementforumcommentaire $forumCommentaire): static
    {
        if (!$this->forumCommentaire->contains($forumCommentaire)) {
            $this->forumCommentaire->add($forumCommentaire);
            $forumCommentaire->setUser($this);
        }

        return $this;
    }

    public function removeForumCommentaire(Signalementforumcommentaire $forumCommentaire): static
    {
        if ($this->forumCommentaire->removeElement($forumCommentaire)) {
            // set the owning side to null (unless already changed)
            if ($forumCommentaire->getUser() === $this) {
                $forumCommentaire->setUser(null);
            }
        }

        return $this;
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
            $liker->setUser($this);
        }

        return $this;
    }

    public function removeLiker(Liker $liker): static
    {
        if ($this->likers->removeElement($liker)) {
            // set the owning side to null (unless already changed)
            if ($liker->getUser() === $this) {
                $liker->setUser(null);
            }
        }

        return $this;
    }


}
