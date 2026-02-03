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
    private ?int $dmg_stat = null;

    #[ORM\Column]
    private ?int $hp_stat = null;

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
        return $this->dmg_stat;
    }

    public function setDmgStat(int $dmg_stat): static
    {
        $this->dmg_stat = $dmg_stat;

        return $this;
    }

    public function getHpStat(): ?int
    {
        return $this->hp_stat;
    }

    public function setHpStat(int $hp_stat): static
    {
        $this->hp_stat = $hp_stat;

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
}
