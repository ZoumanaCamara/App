<?php

namespace App\DataFixtures;

use App\Entity\Hobby;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HobbyFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $tabJob = [
            "FootBall",
            "BasketBall", 
            "Musique", 
            "Natation", 
            "Lecture", 
            "Cinema", 
            "Voyage",
            "Internet" 
        ]; 
        for ($i = 0; $i < count($tabJob); $i++) {
            
            $hobby = new Hobby(); 
            $hobby->setDesignation($tabJob[$i]);
            $manager->persist($hobby);
        }

        $manager->flush();
    }
}
