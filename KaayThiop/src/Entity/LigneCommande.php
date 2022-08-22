<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LigneCommandeRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: LigneCommandeRepository::class)]
class LigneCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'float', nullable: true)]
    private $prix;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['commande:write:simple','commande:simple','client:read','client:readItem'])]
    private $quantite;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'ligneCommandes')]
    private $commande;

    #[ORM\ManyToOne(targetEntity: Produit::class, inversedBy: 'ligneCommandes')]
    #[Groups(['commande:write:simple','commande:simple','client:read','client:readItem'])]
    private $produit;

    #[ORM\OneToMany(mappedBy: 'lignecommande', targetEntity: LigneBT::class,cascade:["persist"])]
    #[SerializedName("Boissons")]
    // #[Groups(['commande:write:simple','commande:simple'])]
    private $ligneBTs;

    public function __construct()
    {
        $this->ligneBTs = new ArrayCollection();
    }

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(?int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * @return Collection<int, LigneBT>
     */
    public function getLigneBTs(): Collection
    {
        return $this->ligneBTs;
    }

    public function addLigneBT(LigneBT $ligneBT): self
    {
        if (!$this->ligneBTs->contains($ligneBT)) {
            $this->ligneBTs[] = $ligneBT;
            $ligneBT->setLignecommande($this);
        }

        return $this;
    }

    public function removeLigneBT(LigneBT $ligneBT): self
    {
        if ($this->ligneBTs->removeElement($ligneBT)) {
            // set the owning side to null (unless already changed)
            if ($ligneBT->getLignecommande() === $this) {
                $ligneBT->setLignecommande(null);
            }
        }

        return $this;
    }

   
}
