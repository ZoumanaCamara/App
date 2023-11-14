<?php

namespace App\Entity;

use App\Entity\Hobby;
use App\Traits\TimeStampTraits;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PersonneRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert; 

#[ORM\Entity(repositoryClass: PersonneRepository::class)]
#[ORM\HasLifecycleCallbacks]

class Personne
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

    #[Assert\Length(min: 3, minMessage: 'Ce champs doit contenir au minimum 3 caractere')]
    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[Assert\Length(min: 3, minMessage: 'Ce champs doit contenir au minimum 3 caractere')]
    #[ORM\Column(length: 50)]
    private ?string $prenom = null;

    #[Assert\NotBlank(message: 'Ce champ ne peut pas etre vide !')]
    #[Assert\Positive(message: 'Vous devez entrez un nombre positive s\'il vous plait !')]    
    #[ORM\Column]
    private ?int $age = null;

    #[Assert\NotBlank(message:'Chaque personne doit avoir obligatoirement un travail ')]
    #[ORM\ManyToOne(inversedBy: 'personnes')]
    private ?Job $job = null;

    #[ORM\ManyToMany(targetEntity: Hobby::class, inversedBy: 'personnes')]
    private Collection $hobbies;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Profile $profile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    

    public function __construct()
    {
        $this->hobbies = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getJob(): ?Job
    {
        return $this->job;
    }

    public function setJob(?Job $job): static
    {
        $this->job = $job;

        return $this;
    }

    /**
     * @return Collection<int, Hobby>
     */
    public function getHobbies(): Collection
    {
        return $this->hobbies;
    }

    public function addHobby(Hobby $hobby): static
    {
        if (!$this->hobbies->contains($hobby)) {
            $this->hobbies->add($hobby);
        }

        return $this;
    }

    public function removeHobby(Hobby $hobby): static
    {
        $this->hobbies->removeElement($hobby);

        return $this;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): static
    {
        $this->profile = $profile;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }


}
