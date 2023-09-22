<?php
// tests/Controller/OeuvresControllerTest.php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class OeuvresControllerTest extends WebTestCase
{
    public function testartDigital()
    {
        // Crée une instance du client HTTP Symfony
        $client = static::createClient();

        // Accède à la page "/oeuvres/catalogue"
        $client->request('GET', '/oeuvres/art_digital');

        // Vérifie que la réponse a un code de statut HTTP 200 (OK)
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

      
    }

   
}
