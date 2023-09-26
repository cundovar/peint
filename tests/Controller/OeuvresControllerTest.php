<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OeuvresControllerTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
      $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
    
    }
}
