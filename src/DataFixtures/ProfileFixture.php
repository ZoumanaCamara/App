<?php

namespace App\DataFixtures;

use App\Entity\Profile;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProfileFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $tabJob = [
            "facebook" => "https://facebook.com/ZoumanaCamara",
            "github" => "https://github.com/ZoumanaCamara", 
            "twitter" => "https://twitter.com/ZoumanaCamara"
        ]; 
        foreach($tabJob as $key => $value) {
            
            $profile = new Profile(); 
            $profile->setReseauSocial($key); 
            $profile->setProfile($value); 
            $manager->persist($profile);
        }

        $manager->flush();
    }
}
