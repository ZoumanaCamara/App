<?php

namespace App\DataFixtures;

use App\Entity\Job;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class JobFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $tabJob = [
            "Informatique",
            "Electronique", 
            "Mecanique", 
            "Arobotique", 
            "Journalisme", 
            "Juge", 
            "Avocat",
            "Marketing" 
        ]; 
        for ($i = 0; $i < count($tabJob); $i++) {
            
            $job = new Job(); 
            $job->setDesignation($tabJob[$i]);
            $manager->persist($job);
        }

        $manager->flush();
    }
}
