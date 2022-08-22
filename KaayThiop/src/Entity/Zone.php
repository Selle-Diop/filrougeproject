<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ZoneRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ZoneRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            'normalization_context'=>['groups' => ['zone:read']],
        ]
        ],
        itemOperations:[
            "get"=>[
            'normalization_context'=>['groups' => ['zone:read']],
        ]
        ]
)]
class Zone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
     #[Groups(['zone:read'])]

    

    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
     #[Groups(['zone:read','commande:simple','client:read','client:readItem','livreur:read'])]

    private $nomZone;

   

    #[ORM\Column(type: 'boolean', nullable: true)]
     #[Groups(['zone:read','client:read','client:readItem'])]

    private $isZone;

    

    

    
    

    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Livraison::class)]
    private $livraison;

    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Commande::class)]
    #[Groups(['zone:read'])]
    private $commandes;
     
    #[ORM\Column(type: 'integer', nullable: true)]
    private $fraisLivraison;

    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Quartier::class)]
     #[Groups(['zone:read'])]

    private $quartiers;

    

    public function __construct()
    {
        // $this->quartiers = new ArrayCollection();
        $this->livraison = new ArrayCollection();
        $this->commandes = new ArrayCollection();


    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomZone(): ?string
    {
        return $this->nomZone;
    }

    public function setNomZone(?string $nomZone): self
    {
        $this->nomZone = $nomZone;

        return $this;
    }

    

    public function isIsZone(): ?bool
    {
        return $this->isZone;
    }

    public function setIsZone(?bool $isZone): self
    {
        $this->isZone = $isZone;

        return $this;
    }

    

    

    /**
     * @return Collection<int, Livraison>
     */
    public function getLivraison(): Collection
    {
        return $this->livraison;
    }

    public function addLivraison(Livraison $livraison): self
    {
        if (!$this->livraison->contains($livraison)) {
            $this->livraison[] = $livraison;
            $livraison->setZone($this);
        }

        return $this;
    }

    public function removeLivraison(Livraison $livraison): self
    {
        if ($this->livraison->removeElement($livraison)) {
            // set the owning side to null (unless already changed)
            if ($livraison->getZone() === $this) {
                $livraison->setZone(null);
            }
        }

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
            $commande->setZone($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getZone() === $this) {
                $commande->setZone(null);
            }
        }

        return $this;
    }

    public function getFraisLivraison(): ?int
    {
        return $this->fraisLivraison;
    }

    public function setFraisLivraison(?int $fraisLivraison): self
    {
        $this->fraisLivraison = $fraisLivraison;

        return $this;
    }

    /**
     * @return Collection<int, Quartier>
     */
    public function getQuartiers(): Collection
    {
        return $this->quartiers;
    }

    public function addQuartier(Quartier $quartier): self
    {
        if (!$this->quartiers->contains($quartier)) {
            $this->quartiers[] = $quartier;
            $quartier->setZone($this);
        }

        return $this;
    }

    public function removeQuartier(Quartier $quartier): self
    {
        if ($this->quartiers->removeElement($quartier)) {
            // set the owning side to null (unless already changed)
            if ($quartier->getZone() === $this) {
                $quartier->setZone(null);
            }
        }

        return $this;
    }

    

    

   

    
}
