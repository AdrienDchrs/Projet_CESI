<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;

use App\Entity\Publication;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class AppFixtures extends Fixture
{
    private Generator $faker; 

    public function __construct() 
    {
        //  Avoir des données en français
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 50; $i++)
        {
            // Création de 50 Utilisateurs
            $user = new User();

            $user->setNom($this->faker->lastName())
             ->setPrenom($this->faker->firstName())
             ->setEmail($this->faker->email())
             ->setPlainPassword('password'); 

            if($i === 1)
                $user->setRoles(['ROLE_ADMIN']);
            else
                $user->setRoles(['ROLE_USER']);


            $manager->persist($user);
        }
        
        // Création de 50 Publications
        for ($i = 1; $i <= 10; $i++)
        {
            $publication = new Publication(); 

            $publication->setTitre($this->faker->sentence())
                        ->setTexte($this->faker->paragraph(5))
                        ->setIdU($user);

            $manager->persist($publication);
        }
        $manager->flush();
    }
}
