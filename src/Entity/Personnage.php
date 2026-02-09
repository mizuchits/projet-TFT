<?php

namespace App\Entity;

use App\Repository\PersonnageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonnageRepository::class)]
class Personnage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $damage = null;

    #[ORM\Column]
    private ?int $hp = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'personnage')]
    private Collection $users;

    #[ORM\ManyToOne(inversedBy: 'personnages')]
    private ?Classe $class = null;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDmgStat(): ?int
    {
        return $this->damage;
    }

    public function setDmgStat(int $damage): static
    {
        $this->damage = $damage;

        return $this;
    }

    public function getHpStat(): ?int
    {
        return $this->hp;
    }

    public function setHpStat(int $hp): static
    {
        $this->hp = $hp;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addPersonnage($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removePersonnage($this);
        }

        return $this;
    }

    public function getClass(): ?Classe
    {
        return $this->class;
    }

    public function setClass(?Classe $class): static
    {
        $this->class = $class;

        return $this;
    }

    public function attaquer(Personnage $cible): void
    {
        $damage = $this->damage;
        $cible->recevoirDegats($damage);
    }

    public function recevoirDegats(int $degats): void
    {
        $this->hp -= $degats;
    }

    public function estVivant(): bool
    {
        return $this->hp > 0;
    }
    
}
