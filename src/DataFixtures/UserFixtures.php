<?php
namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $usernames = ['user1', 'user2', 'user3', 'user4', 'user5', 'user6', 'user7', 'user8', 'user9', 'user10'];

        foreach ($usernames as $username) {
            $user = new User();
            $user->setEmail($username . '@example.com'); // Utilisation d'un nom d'utilisateur pour générer des e-mails uniques
            $user->setPassword('123456');
            $manager->persist($user);
        }
        
        $manager->flush();
    }
}
