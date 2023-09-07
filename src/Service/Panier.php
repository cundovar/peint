<?php

namespace App\Service;

use ftp;
use App\Entity\Commande;
use App\Entity\DetailsCommande;
use App\Repository\OeuvresRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Panier
{


    private $session;
    private $repoOeuvre;
    private $manager;


    public function __construct(SessionInterface $session, OeuvresRepository $repoOeuvre, EntityManagerInterface $manager)
    {
        $this->session=$session;
        $this->repoOeuvre=$repoOeuvre;
        $this->manager=$manager;
    }



    public function creation()
    {
        $array=[

            'id'=>[],
            'prix'=>[],
            'quantity'=>[],
            "titre"=>[],
            "image"=>[]

        ];
        return $array;
    }




    public function add($id,$prix,$quantity,$titre,$image)
    {
        $panier=$this->session->get('panier');
     
        if(empty($panier))
       
        {
            $panier=$this->creation();
    
            $this->session->set('panier',$panier);                  
            
        }
     
        // array_splice(1:valeur recherché, 2: dans quel tableau)
        //  recherche idoeuvre dans panier renvoir true ou false 
        // $this->session->set('panier") recupère le panier dans session apres cration si id oeuvre est dans ce panier alors $panier ['quantity ][$positio_search]+-=$quantity cela veut dire : augmenter la quantité du panier 
        //tableau $panier tableau quantité et id + quantité nouevlle valeur
        //
        $position_search=array_search($id,$panier['id'] );
        if($position_search !== false)
        {
            $panier['quantity'][$position_search]+=$quantity;
            
           

         }

         else
         {

            $panier['id'][]=$id;
            $panier['prix'][]=$prix;
            $panier['quantity'][]=$quantity;
            $panier['titre'][]=$titre;
            $panier['image'][]=$image;
            

         }
         $this->session->set('panier',$panier);
    }


    public function vider()
    {
           
        $panier=$this->creation();
        $this->session->set('panier',$panier);
    }

    public function remove($id)
    {
                $panier=$this->session->get('panier');

                $position=array_search($id,$panier['id'] );

          

       array_splice($panier['id'],$position,1 );
       array_splice($panier['titre'],$position,1 );
       array_splice($panier['prix'],$position,1 );
       array_splice($panier['quantity'],$position,1 );
       array_splice($panier['image'],$position,1 );


       $this->session->set('panier',$panier);
       

    }


    public function montant()
    {
    
        $montant=0;
        $panier=$this->session->get('panier');
        if (isset($panier['id'])){
            $size=count($panier['id'] );
            for ($i=0; $i < $size;$i++)
            {
                $montant +=$panier['quantity'][$i]*$panier['prix'][$i];
    
            }
            $montant = round($montant,2);
    
            return $montant;
        }
   

       
    }


    

    public function verification()
    {

        $panier = $this->session->get("panier") ;
        $size = count($panier['id'] );

        for($i=0; $i < $size;$i++)
        {
            $oeuvre=$this->repoOeuvre->find($panier['id'][$i] );

            if($oeuvre->getStock())
            {
                if($oeuvre->getStock() < $panier ['quantity'][$i] )
                { 
                    $panier['quantity'][$i]=$oeuvre->getStock();
                }
                
            }
            else
            {
                $panier['quantity'][$i]=0;
            }
        }

        $this->session->set('panier',$panier);
    }



    public function paiement($user)
    {

        $this->verification();

        $panier=$this->session->get('panier');

        $size=count($panier['id'] );

        $acces=false;

        for($i=0; $i<$size;$i++)// si $i ! 0 alors acces is true
        {
            if($panier['quantity'][$i] )
            {
                $acces=true;
            }
        }



        if($acces)
        {
            $commande=new Commande;
            $commande->setUser($user);
         
            $commande->setDateAt(new \DateTimeImmutable('now'));
            $commande->setEtat(0);

            $this->manager->persist($commande);
            $this->manager->flush();

            for($i=0;$i < $size;$i++)
            {
                if($panier['quantity'][$i] )
                {
                    $oeuvre=$this->repoOeuvre->find($panier['id'][$i] );


                    $detail=new DetailsCommande;
                    $detail->setCommande($commande);
                    $detail->setOeuvre($oeuvre);
                    $detail->setQuantity($panier['quantity'][$i] );
                    $detail->setPrix($panier['prix'][$i] );

                    $this->manager->persist($detail);
                    $this->manager->flush();


                    $stockBdd=$oeuvre->getStock();

                    $newStock=$stockBdd - $panier['quantity'][$i];

                    $oeuvre->setStock($newStock);

                    $this->manager->persist($oeuvre);
                    $this->manager->flush();

                    $this->remove($panier['id'][$i] );

                }
            }

        }


    }


}