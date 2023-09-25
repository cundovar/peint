<?php

namespace App\Controller;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Response as TestResponse;
use App\Entity\Oeuvres;
use App\Form\Oeuvres2Type;
use App\filter\OeuvreFilter;
use App\Form\OeuvreFilterType;
// use App\Form\OeuvresType;
use App\Entity\Commentaire;
use App\Entity\OeuvreMatieres;
use App\Form\CommentaireType;
use App\Repository\OeuvresRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CommentaireRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class OeuvresController extends AbstractController
{
    /**
     * @Route("/oeuvres/", name="app_oeuvres_index", methods={"GET","POST"})
     */
    public function index(OeuvresRepository $oeuvresRepository):Response
    {
        $oeuvre=$oeuvresRepository->findByCategorie(2);
            
        
        return $this->render('main/index.html.twig',[
           
            "oeuvres"=>$oeuvre
        ]);

    }

    
    
    /**
     * @Route("/oeuvres/catalogue", name="catalogue")
     */
    public function catalogue(OeuvresRepository $repoOeuvre,  Request $request){
        
       $filter=new OeuvreFilter;
       $form=$this->createForm(OeuvreFilterType::class,$filter);
       $form->handleRequest($request);
      
     
       $oeuvres =$repoOeuvre->findFiltre($filter);
    //    $produits =$repoProduit->findAll();



        return $this->render("oeuvres/catalogue.html.twig", [
            "oeuvres" => $oeuvres,
            "formFilter" => $form->createView()
        ]);
    }
    


    /**
    * @Route("/oeuvres/art_digital",name="artDigital",methods={"GET"} )
    */
   
       public function artDigital(OeuvresRepository $oeuvresRepository,Request $request,PaginatorInterface $paginator): Response
       {
   
           $donnees=$oeuvresRepository->findByCategorie(1);
           $oeuvre=$paginator->paginate(
                  $donnees,
                  $request->query->getInt('page',1),
                  5
           );
         
           return $this->render('oeuvres/art_digital.html.twig',[
               "oeuvres"=>$oeuvre,
              
           ]);
   
       }
   /**
    * @Route("/oeuvres/peinture",name="peinture",methods={"GET"} )
    */
   
   public function peinture(OeuvresRepository $oeuvresRepository,Request $request,PaginatorInterface $paginator): Response
   {
   
       $donnees=$oeuvresRepository->findByCategorie(2);
       $oeuvre=$paginator->paginate(
        $donnees,
        $request->query->getInt('page',1),
        5
 );

       return $this->render('oeuvres/peinture.html.twig',[
           "oeuvres"=>$oeuvre
       ]);
   
   }
    /**
     * @Route("/oeuvres/mention_legal", name="mention_legal")
     */
    public function mention_legal()
    {
        return $this->render('oeuvres/mentionLegal.html.twig');
    }


    /**
     * @Route("/oeuvres/{id}", name="app_oeuvre_show")
     * 
  
     */
    public function show(Oeuvres $oeuvre): Response
    {
       
        return $this->render('oeuvres/show.html.twig', [
            'oeuvre' => $oeuvre,
            
        ]);
    }
   


    

    

  
    
 




}