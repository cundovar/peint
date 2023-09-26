<?php
namespace App\Tests\Controller;

use App\Entity\Oeuvres;
use App\Form\Oeuvres2Type;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class AdminOeuvreControllerTest extends WebTestCase
{
    public function testNew()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin/oeuvre/new');
        $this->assertResponseIsSuccessful();

 
        $formData = [
            'oeuvres2' => [
                'titre' => 'Nouvelle œuvre',
                'prix' => 19.99,
                'stock' => 10,
                'categorie' => 1,
                'description' => 'Description de la nouvelle œuvre',
                'matiere' => [2], 
                'dimention' => 'Dimensions de la nouvelle œuvre',
               
            ],
        ];

        $form = $crawler->selectButton('Ajouter')->form();
        $client->submit($form, $formData);



        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        $repository = $entityManager->getRepository(Oeuvres::class); 
        $object = $repository->findOneBy(['titre' => 'Nouvelle œuvre']); 
        $this->assertInstanceOf(Oeuvres::class, $object);

 

    }

    public function testEdit()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin/oeuvre/8/edit');
        $this->assertResponseIsSuccessful();
    
        $formData = [
            'Oeuvres2Type' => [
                'titre' => 'Nouveau titre',
                'prix' => 200,
                'stock' => 2,
                'categorie' => 1,
                'description' => 'Description ',
                'matiere' => [2],
                'dimention' => 'Dimensions ',
              
                
            ],
        ];
        
       
        $form = $crawler->selectButton('Modifier')->form();
        $client->submit($form, $formData);
    
      
    
      
        $this->assertResponseRedirects('/admin/oeuvre');
    }
}    