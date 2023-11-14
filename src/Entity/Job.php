<?php

namespace App\Entity;

use App\Traits\TimeStampTraits;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\JobRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: JobRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Job
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

    #[ORM\Column(length: 50)]
    private ?string $designation = null;

    #[ORM\OneToMany(mappedBy: 'job', targetEntity: Personne::class)]
    private Collection $personnes;

    public function __construct()
    {
        $this->personnes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): static
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * @return Collection<int, Personne>
     */
    public function getPersonnes(): Collection
    {
        return $this->personnes;
    }

    public function addPersonne(Personne $personne): static
    {
        if (!$this->personnes->contains($personne)) {
            $this->personnes->add($personne);
            $personne->setJob($this);
        }

        return $this;
    }

    public function removePersonne(Personne $personne): static
    {
        if ($this->personnes->removeElement($personne)) {
            // set the owning side to null (unless already changed)
            if ($personne->getJob() === $this) {
                $personne->setJob(null);
            }
        }

        return $this;
    }

    public function __toString() : string
    {
        return $this->designation; 
    }
}