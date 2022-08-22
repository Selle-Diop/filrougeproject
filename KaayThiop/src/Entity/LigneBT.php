<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LigneBTRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LigneBTRepository::class)]
#[ApiResource]
class LigneBT
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['commande:write:simple','commande:simple'])]

    private $quantite;

    #[ORM\ManyToOne(targetEntity: LigneCommande::class, inversedBy: 'ligneBTs')]
    private $lignecommande;

    #[ORM\ManyToOne(targetEntity: TailleBoisson::class, inversedBy: 'ligneBTs')]
    #[Groups(['commande:write:simple','commande:simple'])]

    private $boissontaille;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLignecommande(): ?LigneCommande
    {
        return $this->lignecommande;
    }

    public function setLignecommande(?LigneCommande $lignecommande): self
    {
        $this->lignecommande = $lignecommande;

        return $this;
    }

    public function getBoissontaille(): ?TailleBoisson
    {
        return $this->boissontaille;
    }

    public function setBoissontaille(?TailleBoisson $boissontaille): self
    {
        $this->boissontaille = $boissontaille;

        return $this;
    }
}
