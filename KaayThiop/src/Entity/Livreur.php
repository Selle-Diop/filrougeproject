<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivreurRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
#[ApiResource(
     collectionOperations:[
        "get"=>[
            "method"=>"get",
            "normalization_context"=>['groups'=> ["livreur"]]
        ]
        ],
    itemOperations:[
        "get"=>[
            "method"=>"get",
            "normalization_context"=>['groups'=> ["livreurI"]]
        ]
    ]
)]

#[ORM\Entity(repositoryClass: LivreurRepository::class)]
class Livreur extends User
{
   
   
    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["livreur","livreurI"])]
    private $matricule;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["livreur","livreurI"])]
    private $telephone;

    #[ORM\OneToMany(mappedBy: 'livreur', targetEntity: Livraison::class)]
    #[Groups(["livreur","livreurI"])]
    private $livraisons;
    #[ORM\Column(type: 'string', length:50, nullable: true)]
    #[Groups(["livreur","livreurI"])]
    private $isEtatLivreur="disponible";

    public function __construct()
    {
        parent::__construct();
        $this->livraisons = new ArrayCollection();
    }

    

   

    

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

  
    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * @return Collection<int, Livraison>
     */
    public function getLivraisons(): Collection
    {
        return $this->livraisons;
    }

    public function addLivraison(Livraison $livraison): self
    {
        if (!$this->livraisons->contains($livraison)) {
            $this->livraisons[] = $livraison;
            $livraison->setLivreur($this);
        }

        return $this;
    }

    public function removeLivraison(Livraison $livraison): self
    {
        if ($this->livraisons->removeElement($livraison)) {
            // set the owning side to null (unless already changed)
            if ($livraison->getLivreur() === $this) {
                $livraison->setLivreur(null);
            }
        }

        return $this;
    }

    public function isIsEtatLivreur(): ?string
    {
        return $this->isEtatLivreur;
    }

    public function setIsEtatLivreur(?string $isEtatLivreur): self
    {
        $this->isEtatLivreur = $isEtatLivreur;

        return $this;
    }

    
}
