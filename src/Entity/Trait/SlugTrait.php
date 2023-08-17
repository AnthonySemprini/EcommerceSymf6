<?php 

namespace App\Entity\Trait;

Use Doctrine\ORM\Mapping as ORM;

trait SlugTrait 
{
    #[ORM\Column(type: 'string', length:255)]
    public $slug;

    public function getSlug(): ?string
    {
        return $this->Slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

}