<?php

namespace App\Controller;

use App\Repository\CommandeRepository;
use App\Repository\OeuvresRepository;
use App\Service\Panier;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="app_profil")
     */
    public function profil(SessionInterface $session,Panier $panier): Response
    {

        $panierSession= $session->get('panier');
        $montant=$panier->montant();
        dump($this->getUser());
        $user = $this->getUser();
        return $this->render('profil/profil.html.twig', [
            "user" => $user,
            'panier'=>$panierSession,
            'montant'=>$montant
         ]);




     
    }
/**
 * 
 * @Route("/ajout",name="ajout")
 */
    public function panier_ajouter(Request $request,OeuvresRepository $repoOeuvre,Panier $panier)
{
    $idOeuvre = $request->request->get('oeuvre');
    $quantity=$request->request->get('quantity');
    $oeuvre=$repoOeuvre->find($idOeuvre);
    $panier->add($idOeuvre,$oeuvre->getPrix(),$quantity,$oeuvre->getTitre(),$oeuvre->getImage());
    return $this->redirectToRoute("app_profil");
}
/**
 * 
 * @Route("/vider_panier",name="vider_panier")
 */
    public function vider_panier(Panier $panier){
        $panier->vider();

        return $this->redirectToRoute("app_profil");
    }
    /**
 * 
 * @Route("/idVider",name="idVider")
 */
    public function panier_videId($id, Panier $panier){
        $panier->remove($id);
        return $this->redirectToRoute("app_profil");

    }

    /**
     * @Route("/commandes",name="commande")
     */
    public function commandes(CommandeRepository $repoCommande)

    {
        $user=$this->getUser();
        $commandes=$repoCommande->findBy(["User"=>$user] );
return $this->render('profil/commandes.html.twig',["commandes"=>$commandes] );

    }


}
