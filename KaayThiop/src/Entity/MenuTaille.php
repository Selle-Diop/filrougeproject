<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuTailleRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: MenuTailleRepository::class)]
#[ApiResource]

class MenuTaille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
     #[Groups(["menu:simple"])]

    private $id;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(["menu:simple","menu:read"])]
    
 #[Assert\Positive(
       message:"la quantite doit etre positive"
   )]
    private $quantite;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menuTailles')]
    private $menus;

    #[ORM\ManyToOne(targetEntity: Taille::class, inversedBy: 'menuTailles')]
    #[Groups(["menu:simple","menu:read"])]

    private $tailles;

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

    public function getTailles(): ?Taille
    {
        return $this->tailles;
    }

    public function setTailles(?Taille $tailles): self
    {
        $this->tailles = $tailles;

        return $this;
    }
}
