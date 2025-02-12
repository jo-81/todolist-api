<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createOne([
            'email' => 'admin@domaine.fr',
            'plainPassword' => '0000',
            'roles' => ['ROLE_ADMIN'],
            'username' => 'admin',
        ]);

        // UserFactory::createMany(10);

        $manager->flush();
    }
}
