<?php

namespace App\DataFixtures;

use App\Entity\Oeuvres;
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

        $manager->flush();
    }
}
