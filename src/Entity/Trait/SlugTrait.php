<?php 

namespace App\Entity\Trait;

Use Doctrine\ORM\Mapping as ORM;

trait SlugTrait 
{
    #[ORM\Column(type: 'string', length:255)]
    private $slug;

    public function getSlugAt(): ?string
    {
        return $this->Slug;
    }

    public function setSlugAt(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

}