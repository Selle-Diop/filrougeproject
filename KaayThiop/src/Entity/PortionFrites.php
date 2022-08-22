<?php

namespace App\Entity;

use App\Entity\Produit;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PortionFritesRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: PortionFritesRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get","post"=>[
            
            'input_formats' => [
                'multipart' => ['multipart/form-data']
            ]
        
    ]
    ]
)]
class PortionFrites extends Produit
{
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
     #[Groups(["menu:read",'complement:read:simple'])]

    private $portions;

     #[Assert\NotBlank(
        message : "le prix est obligatoire"
     )]
     #[Groups(["menu:read",'complement:read:simple'])]

    protected $prix;

    
    #[ORM\OneToMany(mappedBy: 'fritesportions', targetEntity: FriteBoisson::class)]
     #[Groups(['complement:read:simple'])]

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
