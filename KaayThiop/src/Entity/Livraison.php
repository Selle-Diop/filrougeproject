<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivraisonRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
#[ApiResource(collectionOperations:[
        "get"=>[
           'normalization_context' => ['groups' => ['livreur:read']] 
        ],"post"=>[
            "method"=>"POST",
             'denormalization_context' => ['groups' => ['livraison:write']],
            
 
        ]  
        ],
         itemOperations:[
        "get"=>[
            "method"=>"get",
            "normalization_context"=>['groups'=> ["livraisonPut"]]
        ]
    ]
        
        )]
class Livraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['livreur:read'])]
    private $id;

    #[Groups(['livreur:read'])]
    #[ORM\Column(type: 'boolean', nullable: true)]
    private $isEtat;

    #[Groups(['commande:write:simple','commande:simple','livreur:read','livraison:write'])]
    #[ORM\ManyToOne(targetEntity: Livreur::class, inversedBy: 'livraisons')]
    private $livreur;

    #[Groups(['livreur:read','livraisonPut','livraison:write'])]
    #[ORM\OneToMany(mappedBy: 'livraison', targetEntity: Commande::class)]
    private $commandes;

    #[Groups(['livreur:read','livraison:write'])]
    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'livraison')]
    private $zone;

    #[ORM\ManyToMany(targetEntity: Zone::class, mappedBy: 'livraisons')]
    

    

    public function __construct()
    {
        $this->commandes = new ArrayCollection();

        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    

    public function isIsEtat(): ?bool
    {
        return $this->isEtat;
    }

    public function setIsEtat(?bool $isEtat): self
    {
        $this->isEtat = $isEtat;

        return $this;
    }

    

    public function getLivreur(): ?Livreur
    {
        return $this->livreur;
    }

    public function setLivreur(?Livreur $livreur): self
    {
        $this->livreur = $livreur;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setLivraison($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getLivraison() === $this) {
                $commande->setLivraison(null);
            }
        }

        return $this;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    
}
