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
     * @ORM\Column(type="float",nullable=true)
     */
    private $montant;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $dateAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $etat;

    

    /**
     * @ORM\OneToMany(targetEntity=DetailsCommande::class, mappedBy="commande")
     */
    private $DetailsCommande;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="commandes")
     */
    private $User;

   
    public function __construct()
    {
        $this->DetailsCommande = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDateAt(): ?\DateTimeImmutable
    {
        return $this->dateAt;
    }

    public function setDateAt(?\DateTimeImmutable $dateAt): self
    {
        $this->dateAt = $dateAt;

        return $this;
    }

    public function getEtat(): ?int
    {
        return $this->etat;
    }

    public function setEtat(?int $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

   
    /**
     * @return Collection<int, DetailsCommande>
     
     */
    public function getDetailsCommande(): Collection
    {
        return $this->DetailsCommande;
    }

    public function addDetailsCommande(DetailsCommande $detailsCommande): self
    {
        if (!$this->DetailsCommande->contains($detailsCommande)) {
            $this->DetailsCommande[] = $detailsCommande;
            $detailsCommande->setCommande($this);
        }

        return $this;
    }

    public function removeDetailsCommande(DetailsCommande $detailsCommande): self
    {
        if ($this->DetailsCommande->removeElement($detailsCommande)) {
            // set the owning side to null (unless already changed)
            if ($detailsCommande->getCommande() === $this) {
                $detailsCommande->setCommande(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

   
}
