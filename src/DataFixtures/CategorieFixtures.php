<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategorieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         $Categorie = new Categorie();
         $Categorie-> setNom('peinture');
         $manager->persist($Categorie);

        $manager->flush();
    }
}
