<?php

namespace App\Entity;

use App\Repository\ConversationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConversationRepository::class)]
class Conversation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'conversations')]
    private ?User $userfirst = null;

    #[ORM\ManyToOne(inversedBy: 'conversations')]
    private ?User $UserSecond = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $message = null;

    #[ORM\ManyToOne(inversedBy: 'conversations')]
    private ?ListAmis $listAmis = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getUserfirst(): ?User
    {
        return $this->userfirst;
    }

    public function setUserfirst(?User $userfirst): static
    {
        $this->userfirst = $userfirst;

        return $this;
    }

    public function getUserSecond(): ?User
    {
        return $this->UserSecond;
    }

    public function setUserSecond(?User $UserSecond): static
    {
        $this->UserSecond = $UserSecond;

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

    public function getListAmis(): ?ListAmis
    {
        return $this->listAmis;
    }

    public function setListAmis(?ListAmis $listAmis): static
    {
        $this->listAmis = $listAmis;

        return $this;
    }

}
