<?php

namespace App\Entity;

use App\Entity\Produit;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PortionFritesRepository;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: PortionFritesRepository::class)]
#[ApiResource]
class PortionFrites extends Produit
{
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $portions;

    #[ORM\OneToMany(mappedBy: 'fritesportions', targetEntity: FriteBoisson::class)]
    private $friteBoissons;

    public function __construct()
    {
        parent::__construct();
        $this->friteBoissons = new ArrayCollection();
    }

   

    

    public function getPortions(): ?string
    {
        return $this->portions;
    }

    public function setPortions(?string $portions): self
    {
        $this->portions = $portions;

        return $this;
    }

    /**
     * @return Collection<int, FriteBoisson>
     */
    public function getFriteBoissons(): Collection
    {
        return $this->friteBoissons;
    }

    public function addFriteBoisson(FriteBoisson $friteBoisson): self
    {
        if (!$this->friteBoissons->contains($friteBoisson)) {
            $this->friteBoissons[] = $friteBoisson;
            $friteBoisson->setFritesportions($this);
        }

        return $this;
    }

    public function removeFriteBoisson(FriteBoisson $friteBoisson): self
    {
        if ($this->friteBoissons->removeElement($friteBoisson)) {
            // set the owning side to null (unless already changed)
            if ($friteBoisson->getFritesportions() === $this) {
                $friteBoisson->setFritesportions(null);
            }
        }

        return $this;
    }

   

    

   

}
