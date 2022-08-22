<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FriteBoissonRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: FriteBoissonRepository::class)]
#[ApiResource]

class FriteBoisson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
     #[Groups(["menu:simple"])]

    private $id;

    #[ORM\Column(type: 'integer', nullable: true)]
     #[Groups(["menu:simple","menu:read",'complement:read:simple'])]
      #[Assert\Positive(
       message:"la quantite doit etre positive"
   )]
   
    private $quantite;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'friteBoissons',cascade:["persist"])]
    private $menus;

    #[ORM\ManyToOne(targetEntity: PortionFrites::class, inversedBy: 'friteBoissons',cascade:["persist"])]
     #[Groups(["menu:simple","menu:read"])]
    private $fritesportions;

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

    public function getMenus(): ?Menu
    {
        return $this->menus;
    }

    public function setMenus(?Menu $menus): self
    {
        $this->menus = $menus;

        return $this;
    }

    public function getFritesportions(): ?PortionFrites
    {
        return $this->fritesportions;
    }

    public function setFritesportions(?PortionFrites $fritesportions): self
    {
        $this->fritesportions = $fritesportions;

        return $this;
    }
}
