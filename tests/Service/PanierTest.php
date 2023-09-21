<?php

use PHPUnit\Framework\TestCase;
use App\Service\Panier;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\OeuvresRepository;
use Doctrine\ORM\EntityManagerInterface;

class PanierTest extends TestCase
{
    private $session;
    private $oeuvresRepository;
    private $entityManager;

    protected function setUp(): void
    {
        parent::setUp();

        // Créez des doubles pour les dépendances
        $this->session = $this->createMock(SessionInterface::class);
        $this->oeuvresRepository = $this->createMock(OeuvresRepository::class);
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
    }

    
    public function testAdd()
    {
        $panier = new Panier($this->session, $this->oeuvresRepository, $this->entityManager);

        $id = 1;
        $prix = 10.0;
        $quantity = 2;
        $titre = 'Titre de l\'oeuvre';
        $image = 'image.jpg';

        $panier->add($id, $prix, $quantity, $titre, $image);
        $result = $this->session->get('panier');

        // Vérifiez que la méthode add() a ajouté les valeurs au panier dans la session
        $this->assertSame([$id], $result['id']);
        $this->assertSame([$prix], $result['prix']);
        $this->assertSame([$quantity], $result['quantity']);
        $this->assertSame([$titre], $result['titre']);
        $this->assertSame([$image], $result['image']);
    }

    public function testVider()
    {
        $panier = new Panier($this->session, $this->oeuvresRepository, $this->entityManager);

        // Simulez l'existence d'un panier dans la session
        $this->session->expects($this->once())
            ->method('get')
            ->with('panier')
            ->willReturn(['id' => [1, 2], 'prix' => [10.0, 20.0]]);

        $panier->vider();
        $result = $this->session->get('panier');

        // Vérifiez que la méthode vider() a vidé le panier dans la session
        $this->assertSame([], $result['id']);
        $this->assertSame([], $result['prix']);
    }
}
