<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OeuvresControllerTest extends WebTestCase
{
    public function testCataloguePage()
    {
        // Crée une instance du client HTTP Symfony
        $client = static::createClient();

        // Accède à la page "/oeuvres/catalogue"
        $client->request('GET', '/oeuvres/catalogue');

        // Vérifie que la réponse a un code de statut HTTP 200 (OK)
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        // Vérifie que le contenu de la réponse contient un élément spécifique
        $this->assertSelectorTextContains('h1', 'Catalogue des oeuvres');

        // Vérifie que le formulaire de filtre est présent
        $this->assertSelectorExists('form[name="oeuvre_filter"]');
    }

    // Vous pouvez ajouter d'autres tests pour d'autres actions ici...

    // Par exemple, un test pour la page "artDigital"
    public function testArtDigitalPage()
    {
        $client = static::createClient();
        $client->request('GET', '/oeuvres/art_digital');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('h1', 'Art Digital');
    }

    // Et un test pour la page "peinture"
    public function testPeinturePage()
    {
        $client = static::createClient();
        $client->request('GET', '/oeuvres/peinture');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('h1', 'Peinture');
    }

    // Vous pouvez ajouter plus de tests selon vos besoins...
}
