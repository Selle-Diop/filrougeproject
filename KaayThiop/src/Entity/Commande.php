<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
           'normalization_context' => ['groups' => ['commande:simple']] 
        ],"post"=>[
            "method"=>"POST",
             'denormalization_context' => ['groups' => ['commande:write:simple']],
            
 
        ]
        ],
        itemOperations:[
            "get"=>[
           'normalization_context' => ['groups' => ['commande:readItem']] 
            ],
            "put"=>[
           'normalization_context' => ['groups' => ['commande:readItem']] 
            ]
        ]
)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['client:read','client:readItem','commande:readItem','commande:simple','zone:read','livreur:read','livraisonPut'])]
    private $id;

    #[Groups(['commande:simple','client:read','client:readItem','zone:read','livreur:read','livraisonPut'])]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $numCommande;
 
    #[ORM\Column(type: 'string', length: 50,nullable: true)]
    #[Groups(['commande:simple','client:write','client:readItem','zone:read','livreur:read','livraisonPut'])]

    private $isEtatCommande="en cours"; 

    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Groups(['commande:simple','client:read','client:readItem','zone:read'])]
    private $dateCommande;

    #[ORM\ManyToOne(targetEntity: Livraison::class, inversedBy: 'commandes')]
    private $livraison;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commandes',cascade:["persist"])]
    #[Groups(["livreur",'commande:write:simple','commande:simple','zone:read'])]
    private $client;
    

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'commandes')]
    private $gestionnaire;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: LigneCommande::class,cascade:["persist"])]
    #[SerializedName("Produits")]
    // #[ApiSubresource]
    #[Groups(['commande:write:simple','commande:simple','client:read','client:readItem'])]
    private $ligneCommandes;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $isEnvoi=false;
    #[Groups(['commande:write:simple','commande:simple','client:read','client:readItem'])]
    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'commandes')]
    private $zone;

    public function __construct()
    {
            $this->numCommande="NUM".date("Y-m-d H:i:s");
            $this->dateCommande=new \DateTime();
            


        $this->ligneCommandes = new ArrayCollection();
    }

   


    

    

 

    

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumCommande(): ?string
    {
        return $this->numCommande;
    }

    public function setNumCommande(?string $numCommande): self
    {
        $this->numCommande = $numCommande;

        return $this;
    }

    public function isIsEtatCommande(): ?string
    {
        return $this->isEtatCommande;
    }

    public function setIsEtatCommande(?string $isEtatCommande): self
    {
        $this->isEtatCommande = $isEtatCommande;

        return $this;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }

    public function setDateCommande(?\DateTimeInterface $dateCommande): self
    {
        $this->dateCommande = $dateCommande;

        return $this;
    }

    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }

    public function setLivraison(?Livraison $livraison): self
    {
        $this->livraison = $livraison;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self
    {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }

    /**
     * @return Collection<int, LigneCommande>
     */
    public function getLigneCommandes(): Collection
    {
        return $this->ligneCommandes;
    }

    public function addLigneCommande(LigneCommande $ligneCommande): self
    {
        if (!$this->ligneCommandes->contains($ligneCommande)) {
            $this->ligneCommandes[] = $ligneCommande;
            $ligneCommande->setCommande($this);
        }

        return $this;
    }

    public function removeLigneCommande(LigneCommande $ligneCommande): self
    {
        if ($this->ligneCommandes->removeElement($ligneCommande)) {
            // set the owning side to null (unless already changed)
            if ($ligneCommande->getCommande() === $this) {
                $ligneCommande->setCommande(null);
            }
        }

        return $this;
    }

    public function isIsEnvoi(): ?bool
    {
        return $this->isEnvoi;
    }

    public function setIsEnvoi(?bool $isEnvoi): self
    {
        $this->isEnvoi = $isEnvoi;

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
