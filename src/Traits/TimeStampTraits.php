<?php 

namespace App\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;




trait TimeStampTraits {


    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

        public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }


    public function setCreatedAt(?\DateTimeInterface $created_at): static
    {
        
        $this->created_at = $created_at;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    #[ORM\PrePersist]
    public function onPrePersit() {

        $this->created_at = new \DateTime(); 
    }

    #[ORM\PreUpdate]
    public function OnPreUpdate() : void {

        $this->updated_at = new \DateTime(); 
    }

}

