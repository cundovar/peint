<?php

// tests/Security/UserAuthenticatorTest.php

namespace App\Tests\Security;

use App\DataFixtures\UserFixtures;
use App\Entity\User;
use App\Security\UserAuthenticator;
use Doctrine\Persistence\ObjectManager;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Bundle\FixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\AbstractBrowser;

class UserAuthenticatorTest extends WebTestCase
{
    use FixturesTrait;
    
    public function testAuthenticationSuccess()
    {
        // Créez un client de test Symfony
        $client = static::createClient();

        // Chargez les utilisateurs factices dans la base de données de test
        $this->loadFixtures([UserFixtures::class]);

        // Récupérez le gestionnaire d'entités de test
        $entityManager = $client->getContainer()->get('doctrine')->getManager();

        // Récupérez un utilisateur factice
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => 'user1@example.com']);

        // Créez une requête de connexion avec les informations de l'utilisateur factice
        $request = Request::create('/login', 'POST', [
            'email' => 'user1@example.com',
            'password' => '123456',
            '_csrf_token' => 'your_csrf_token_here', // Remplacez par un vrai jeton CSRF
        ]);

        // Créez une instance de votre UserAuthenticator
        $authenticator = new UserAuthenticator($client->getContainer()->get('router'));

        // Authentifiez l'utilisateur
        $token = $authenticator->authenticateUser($user, $request);

        // Assurez-vous que le token est valide
        $this->assertInstanceOf(UsernamePasswordToken::class, $token);

        // Assurez-vous que l'utilisateur dans le token est le bon utilisateur
        $this->assertInstanceOf(UserInterface::class, $token->getUser());
        $this->assertEquals('user1@example.com', $token->getUsername());
    }
}
