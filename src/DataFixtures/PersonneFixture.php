<?php

namespace App\DataFixtures;

use App\Entity\Personne;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PersonneFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_FR"); 

        
        for($i = 0; $i < 150; $i++) {
            $personne = new Personne(); 

            $personne->setNom($faker->name);
            $personne->setPrenom($faker->firstName); 
            $personne->setAge($faker->numberBetween(18, 60)); 

            $manager->persist($personne); 
        }


        $manager->flush();
    }
}
