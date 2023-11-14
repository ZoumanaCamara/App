<?php

namespace App\Entity;

use App\Traits\TimeStampTraits;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProfileRepository;

#[ORM\Entity(repositoryClass: ProfileRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Profile
{

    /**
     * 
     * Utiliser le time stamp trait pour le created_at et le updated_at
     */
    use TimeStampTraits; 
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $reseau_social = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $profile = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReseauSocial(): ?string
    {
        return $this->reseau_social;
    }

    public function setReseauSocial(string $reseau_social): static
    {
        $this->reseau_social = $reseau_social;

        return $this;
    }

    public function getProfile(): ?string
    {
        return $this->profile;
    }

    public function setProfile(?string $profile): static
    {
        $this->profile = $profile;

        return $this;
    }

    public function __toString() : string
    {
        return $this->reseau_social . " : " . $this->profile; 
    }
}
