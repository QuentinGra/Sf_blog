<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = (new User())
            ->setFirstName('Quentin')
            ->setLastName('Grange')
            ->setEmail('admin@test.com')
            ->setPassword(
                $this->hasher->hashPassword(new User(), 'Test1234!')
            )
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);

        for ($i = 0; $i < 10; ++$i) {
            $user = (new User())
                ->setFirstName("User $i")
                ->setLastName('Test')
                ->setEmail("user-$i@test.com")
                ->setPassword(
                    $this->hasher->hashPassword(new User(), 'Test1234!')
                );

            $manager->persist($user);
        }

        $manager->flush();
    }
}
