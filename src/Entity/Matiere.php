<?php

namespace App\Entity;

use App\Repository\MatiereRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * @ApiResource(
 *  normalizationContext={"groups"={"oeuvre_read"}},
 *  collectionOperations={"get"},
 *     itemOperations={"get"},

 * )
 * 
 * @ORM\Entity(repositoryClass=MatiereRepository::class)
 * @UniqueEntity(
 * fields={"nom"},
 * message="Cette matière existe déjà"
 * )
 * 
 * 
 */
 
class Matiere
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  @Assert\NotBlank(message="Veuillez saisir un nom de matière")
     * @Groups({"oeuvre_read"})
     */
    private $nom;

    /**
     * @ORM\ManyToMany(targetEntity=Oeuvres::class, mappedBy="matiere")
     * @ORM\JoinTable(name="matiere_oeuvres")
     */
    private $oeuvre;

   

  
   
 
 



    public function __construct()
    {
        $this->oeuvre = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

   

    /**
     * @return Collection<int, Oeuvres>
     */
    public function getOeuvre(): Collection
    {
        return $this->oeuvre;
    }

    public function addOeuvre(Oeuvres $oeuvre): self
    {
        if (!$this->oeuvre->contains($oeuvre)) {
            $this->oeuvre[] = $oeuvre;
            $oeuvre->addMatiere($this);
        }

        return $this;
    }

    public function removeOeuvre(Oeuvres $oeuvre): self
    {
       if( $this->oeuvre->removeElement($oeuvre)){
        $oeuvre->removeMatiere($this);
       }

        return $this;
    }


  


    

}
