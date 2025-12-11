<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reference;

    /**
     * @ORM\OneToMany(targetEntity=CommandeQuantite::class, mappedBy="commande")
     */
    private $commandeQuantite;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="commandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this->commandeQuantite = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * @return Collection<int, CommandeQuantite>
     */
    public function getCommandeQuantite(): Collection
    {
        return $this->commandeQuantite;
    }

    public function addCommandeQuantite(CommandeQuantite $commandeQuantite): self
    {
        if (!$this->commandeQuantite->contains($commandeQuantite)) {
            $this->commandeQuantite[] = $commandeQuantite;
            $commandeQuantite->setCommande($this);
        }

        return $this;
    }

    public function removeCommandeQuantite(CommandeQuantite $commandeQuantite): self
    {
        if ($this->commandeQuantite->removeElement($commandeQuantite)) {
            // set the owning side to null (unless already changed)
            if ($commandeQuantite->getCommande() === $this) {
                $commandeQuantite->setCommande(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

   
}
