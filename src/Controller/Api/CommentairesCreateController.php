<?php

namespace App\Controller\Api;

use App\Entity\Commentaire;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;

class CommentairesCreateController extends AbstractController
{
    private $security;
   public function __construct(Security $security)
   {
    $this->security=$security;
   }
    public function __invoke(Commentaire $data)
    {
      $data->setUser($this->security->getUser());
      return $data;
    }
   
    


}
