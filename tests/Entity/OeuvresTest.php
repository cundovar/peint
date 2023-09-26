<?php

use App\Entity\Oeuvres;
use Symfony\Component\Panther\PantherTestCase;

class OeuvresTest extends PantherTestCase
{
    public function testCreation()
    {
        $client = self::createPantherClient();

        // Créez une nouvelle instance d'Oeuvres
        $oeuvre = new Oeuvres();
        $oeuvre->setTitre('Mon titre');
        $oeuvre->setPrix(19.99);
        // ... configurez d'autres propriétés de l'oeuvre ...

        // Enregistrez l'oeuvre dans la base de données
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        $entityManager->persist($oeuvre);
        $entityManager->flush();

        // Utilisez une requête Panther pour accéder à la page qui affiche l'oeuvre
        $crawler = $client->request('GET', '/oeuvres/' . $oeuvre->getId());

        // Utilisez des assertions Panther pour vérifier si l'oeuvre est affichée correctement
        $this->assertSelectorTextContains('h1', 'Mon titre');
        $this->assertSelectorTextContains('.prix', '19.99');
        // ... ajoutez d'autres assertions ...

        // Vous pouvez également utiliser Panther pour soumettre des formulaires, cliquer sur des liens, etc.

        // Assurez-vous de nettoyer la base de données après le test
        $entityManager->remove($oeuvre);
        $entityManager->flush();
    }

    // Écrivez d'autres méthodes de test pour d'autres fonctionnalités de la classe Oeuvres
}
