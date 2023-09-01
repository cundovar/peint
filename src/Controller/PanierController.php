<?php

namespace App\Controller;

use App\Repository\CommandeRepository;
use App\Service\Panier;

use App\Repository\OeuvresRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/panier")
 */

class PanierController extends AbstractController

{
/**
 * 
 * @Route("/",name="app_panier" )
 */
public function index(SessionInterface $session, Panier $panier):Response
{
    // dump($session->get('panier'));


    // $panier->verification();

    $panierSession = $session->get('panier');

    $montant=$panier->montant();



return $this->render ('panier/index.html.twig',[
    "panier"=> $panierSession,
    "montant"=>$montant
]);


 }



/**
 * 
 * @Route("/ajouter",name="panier_ajouter")
 */
public function panier_ajouter(Request $request,OeuvresRepository $repoOeuvre,Panier $panier)
{
    $idOeuvre = $request->request->get('oeuvre');
    $quantity=$request->request->get('quantity');
    $oeuvre=$repoOeuvre->find($idOeuvre);
    $panier->add($idOeuvre,$oeuvre->getPrix(),$quantity,$oeuvre->getTitre(),$oeuvre->getImage());
    return $this->redirectToRoute("app_panier");
}
/**
 * 
 * @Route("/vider",name="panier_vider")
 */
public function panier_vider(Panier $panier)
{
    $panier->vider();

    return $this->redirectToRoute("app_panier");
}
/**
 * 
 * @Route("/retirer/{id}",name="panier_retirer")
 */
public function panier_retirer($id, Panier $panier)
{
    $panier->remove($id);
    return $this->redirectToRoute("app_panier");
}

/**
 * 
 * @Route("/payer",name="panier_payer")
 */
public function panier_payer(Panier $panier)
{
    $user=$this->getUser();//pour pouvoir acceder à cette fonction faut etre connecté
    $panier->paiement($user);
    $this->addFlash("success","commande prise en compte");

    return $this->redirectToRoute("app_panier");


}
/**
 * @Route("/commandes",name="commande")
 */

public function mesCommandes(CommandeRepository $commande)
{
    // addDetailsCommande();
return $this->render('panier/commandes.html.twig', [
    'commandes' => $commande->findAll(),
]);
}









}