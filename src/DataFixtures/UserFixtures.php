<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $_passwordHasher;

    /**
     * Function to hash password
     *
     * @param UserPasswordHasherInterface $_passwordHasher
     */
    public function __construct(UserPasswordHasherInterface $_passwordHasher)
    {
        $this->passwordHasher = $_passwordHasher;
    }
    
    /**
     * Function to load fixtures
     *
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i=0; $i<20; $i++) {
            $user = new User();
            $user->setEmail($faker->email);
            $user->setPassword(
                $this->passwordHasher->hashPassword(
                    $user,
                    'password'
                )
            );
            $manager->persist($user);
        }

        $manager->flush();
    }
}
