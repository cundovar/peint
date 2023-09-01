<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\Oeuvres;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommentaireRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource(
 * 
 *   attributes={
 
 *     "order"={"dateAt":"DESC"},
 * },
 *      paginationItemsPerPage=1,
 *        normalizationContext={"groups"={"read:comment"}},
      *      collectionOperations={"get",
        * "post"={"controller"=App\Controller\Api\CommentairesCreateController::class }},
       
    *       itemOperations={
     *      "get"={
     *             "normalization_context"={"groups"={"read:comment","read:full:comment"}},
     * "post"
     *              }},
     * )
     *                  
      *      
 * 
 * @ApiFilter(SearchFilter::class, properties={"oeuvre":"exact"})
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 */
class Commentaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read:comment"})
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     *  @Groups({"read:comment"})
   
     */
    private $comment;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     * @Groups({"read:comment"})
     */
    private $dateAt;

    /**
     * @ORM\ManyToOne(targetEntity=Oeuvres::class, inversedBy="commentaires")
     *  @Groups({"read:full:comment"})
     */
    private $oeuvre;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="commentaires")
     *  @Groups({"read:comment"})
    
     */
    private $user;

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

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

    public function getOeuvre(): ?Oeuvres
    {
        return $this->oeuvre;
    }

    public function setOeuvre(?Oeuvres $oeuvre): self
    {
        $this->oeuvre = $oeuvre;

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
