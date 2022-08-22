<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TailleBoissonRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TailleBoissonRepository::class)]
#[ApiResource]
class TailleBoisson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
//  #[Groups(['taille:read'])]

    private $id;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $StockBoisson;
 #[Groups(['taille:read',"menu:read",'commande:simple'])]
    #[ORM\ManyToOne(targetEntity: Boisson::class, inversedBy: 'tailleBoissons')]
    private $boisson;

    #[ORM\ManyToOne(targetEntity: Taille::class, inversedBy: 'tailleBoissons')]
    private $taille;

    #[ORM\OneToMany(mappedBy: 'boissontaille', targetEntity: LigneBT::class)]
    private $ligneBTs;

    public function __construct()
    {
        $this->ligneBTs = new ArrayCollection();
    }


   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStockBoisson(): ?int
    {
        return $this->StockBoisson;
    }

    public function setStockBoisson(?int $StockBoisson): self
    {
        $this->StockBoisson = $StockBoisson;

        return $this;
    }

    public function getBoisson(): ?Boisson
    {
        return $this->boisson;
    }

    public function setBoisson(?Boisson $boisson): self
    {
        $this->boisson = $boisson;

        return $this;
    }

    public function getTaille(): ?Taille
    {
        return $this->taille;
    }

    public function setTaille(?Taille $taille): self
    {
        $this->taille = $taille;

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
            $ligneBT->setBoissontaille($this);
        }

        return $this;
    }

    public function removeLigneBT(LigneBT $ligneBT): self
    {
        if ($this->ligneBTs->removeElement($ligneBT)) {
            // set the owning side to null (unless already changed)
            if ($ligneBT->getBoissontaille() === $this) {
                $ligneBT->setBoissontaille(null);
            }
        }

        return $this;
    }

    
}
