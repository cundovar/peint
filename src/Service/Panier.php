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


    //creer l'achitecture du panier dans une fonction
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




    public function add($id,$prix,$quantity,$titre,$image)// il faudra mettre 4 arguments dans la function add
    {
        $panier=$this->session->get('panier');
        //on appelle l'objet session on pren element s'appelant panier dans ma session
        if(empty($panier))
       
        {
            $panier=$this->creation();// on appele la function creation
            // pour appeler un function $this->
            $this->session->set('panier',$panier);                  
            
        }
        
        // dans la sesion il y a forcement le tableau panier vide ou non avec la condition if
        
        /*
        function predefini php:
        array_search
        ->permet de rechercher une valeur dans le tableau
        ==>retournr ma POSITION dans le tableau 
        ==>retourne rien s'il nexiste pas 
        
        2arguments :
        -valeur recherché
        -tableau
        */
        
        $position_search=array_search($id,$panier['id'] );
        if($position_search !== false)// si le produit existe dans le panier
        {
            $panier['quantity'][$position_search]+=$quantity;
            
           

         }

         else//et si le produit nexiste pas dans le panier 
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
            // $this->session->remove("panier");// supremier le tableau panier de la session d=redevient null
        $panier=$this->creation();
        $this->session->set('panier',$panier);// ou alors
    }

    public function remove($id)// pour suprimer un element du panier
    {
                $panier=$this->session->get('panier');

                $position=array_search($id,$panier['id'] );// position dans le tableau

            // dd($position);// affiche 1 car en position 1 dans le tableau si on supp la 1er ligne....

            /* fonction predefini php
            array_splice
            ->permet d'effacer une portion un ou des elements dans un tableau
            3 arguments:

            1 tableau
            2 la position
            3le nombres d"elements à supprimer 1 cest une ligne si on ecrti 2 alors ces't deux ligne a partir de la position selectionné
        $tableau = ["id",]

        for($i=0;$i<4;$++)
        {
        array_splice($panier['$tableau'],$position,1 );

        }



       
       */

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
       
         //dd($size);

       
    }


    

    public function verification()
    {

        $panier = $this->session->get("panier") ;//on recuprer de la session notre panier
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
            // $commande->setMontant($this->montant());
            $commande->setDateAt(new \DateTimeImmutable('now'));
            $commande->setEtat(0);// 0=en cours de tratement; 1 expedié;2 livré

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