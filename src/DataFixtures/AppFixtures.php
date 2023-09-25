<?php

namespace App\DataFixtures;


use App\Entity\Commentaire;
use App\Entity\Matiere;
use App\Entity\Oeuvres;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $product = new Oeuvres();
        $product->setTitre('Produit de test');
        $product->setPrix(19.99);
        $manager->persist($product);
        
        $matiere= new Matiere();
        $matiere->setNom('digital');
        $manager->persist($matiere);

        $commentaire = new Commentaire();
        $commentaire->setComment('Ceci est un commentaire.');
        $commentaire->setDateAt(new \DateTimeImmutable());
        $commentaire->setOeuvre($product); // Assurez-vous d'associer le commentaire à l'œuvre
        
        // Associez l'utilisateur qui a laissé le commentaire en utilisant l'un des utilisateurs factices
        $user = $manager->getRepository(User::class)->findOneBy(['email' => 'user1@example.com']);
        if ($user) {
            $commentaire->setUser($user);
        }
        
        $manager->persist($commentaire);



        

        $manager->flush();

        
    }
}
