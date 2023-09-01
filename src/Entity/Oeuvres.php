<?php

namespace App\Entity;
use App\Entity\Categorie;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\OeuvresRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *  normalizationContext={"groups"={"oeuvre_read"}},
 *  collectionOperations={"get"},
 *     itemOperations={"get"},
 * )
 * 

 * @ORM\Entity(repositoryClass=OeuvresRepository::class)
 */
class Oeuvres
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  @Groups({"read:full:comment","oeuvre_read"})
     * 

     */
    private $titre;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups("oeuvre_read")
     */
    private $prix;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"oeuvre_read"})

     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity=DetailsCommande::class, mappedBy="oeuvre")
     */
    private $detailsCommandes;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\NotBlank( message="saisir stock")
     * @Assert\PositiveOrZero( message="saisir stock sup ou egale à zero")
     */
    private $stock;

   
    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $DateAt;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="oeuvres")
     *  @Groups("oeuvre_read")
     */
    private $categorie;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="oeuvre")
     */
    private $commentaires;

 
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("oeuvre_read")
     */
    private $dimention;

    /**
     * @ORM\ManyToMany(targetEntity=Matiere::class, inversedBy="oeuvre")
     * 
     */
    private $matiere;

  


   

    
    public function __construct()
    {
        $this->detailsCommandes = new ArrayCollection();
        // $this->categorie = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->matiere = new ArrayCollection();
     
      
      
      
       
      
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, DetailsCommande>
     */
    public function getDetailsCommandes(): Collection
    {
        return $this->detailsCommandes;
    }

    public function addDetailsCommande(DetailsCommande $detailsCommande): self
    {
        if (!$this->detailsCommandes->contains($detailsCommande)) {
            $this->detailsCommandes[] = $detailsCommande;
            $detailsCommande->setOeuvre($this);
        }

        return $this;
    }

    public function removeDetailsCommande(DetailsCommande $detailsCommande): self
    {
        if ($this->detailsCommandes->removeElement($detailsCommande)) {
            // set the owning side to null (unless already changed)
            if ($detailsCommande->getOeuvre() === $this) {
                $detailsCommande->setOeuvre(null);
            }
        }

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(?int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    

    public function getDateAt(): ?\DateTimeImmutable
    {
        return $this->DateAt;
    }

    public function setDateAt(?\DateTimeImmutable $DateAt): self
    {
        $this->DateAt = $DateAt;

        return $this;
    }
     

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setOeuvre($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getOeuvre() === $this) {
                $commentaire->setOeuvre(null);
            }
        }

        return $this;
    }

    

   
    public function getDimention(): ?string
    {
        return $this->dimention;
    }

    public function setDimention(?string $dimention): self
    {
        $this->dimention = $dimention;

        return $this;
    }

    /**
     * @return Collection<int, Matiere>
     */
    public function getMatiere(): Collection
    {
        return $this->matiere;
    }

    public function addMatiere(Matiere $matiere): self
    {
        if (!$this->matiere->contains($matiere)) {
            $this->matiere[] = $matiere;
         
        }

        return $this;
    }

    public function removeMatiere(Matiere $matiere): self
    {
        $this->matiere->removeElement($matiere);
        
        

        return $this;
    }


   
}