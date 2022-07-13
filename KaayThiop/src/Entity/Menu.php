<?php

namespace App\Entity; 

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use App\Controller\Menu2Controller;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
#[ApiResource(
    collectionOperations:[
        "post"=>[
            "method"=>"POST",
            "denormalization_context"=>["groups"=>["menu:simple"]],
            "normalization_context"=>["groups"=>["menu:normal"]]

        ],
        "add"=>[
             "method"=>"POST",
             "path"=>"/menu2",
             "controller"=>Menu2Controller::class
        ]
    ]
)]
class Menu extends Produit
{
    #[Groups(["menu:simple","menu:normal"])]
    protected $nom;
    #[Groups(["menu:simple","menu:normal"])]
    protected $prix;
    #[ORM\OneToMany(mappedBy: 'menus', targetEntity: MenuBurger::class,cascade:["persist"])]
    #[Groups(["menu:simple"])]
    #[SerializedName("Burgers")]
    #[Assert\NotBlank()]
    #[Assert\Valid()]
    #[Assert\Count(
        min:1,
        minMessage:"le menu doit avoir au moins un burger"
    )]
    private $menuBurgers;

    #[ORM\OneToMany(mappedBy: 'menus', targetEntity: MenuTaille::class,cascade:["persist"])]
    #[Groups(["menu:simple"])]
    #[SerializedName("Tailles")]
    private $menuTailles;

    #[ORM\OneToMany(mappedBy: 'menus', targetEntity: FriteBoisson::class,cascade:["persist"])]
    #[Groups(["menu:simple"])]
    #[SerializedName("Frites")]
    private $friteBoissons;

    public function __construct()
    {
        parent::__construct();
        $this->menuBurgers = new ArrayCollection();
        $this->menuTailles = new ArrayCollection();
        $this->friteBoissons = new ArrayCollection();
    }

    /**
     * @return Collection<int, MenuBurger>
     */
    public function getMenuBurgers(): Collection
    {
        return $this->menuBurgers;
    }

    public function addMenuBurger(MenuBurger $menuBurger): self
    {
        if (!$this->menuBurgers->contains($menuBurger)) {
            $this->menuBurgers[] = $menuBurger;
            $menuBurger->setMenus($this);
        }

        return $this;
    }

    public function removeMenuBurger(MenuBurger $menuBurger): self
    {
        if ($this->menuBurgers->removeElement($menuBurger)) {
            // set the owning side to null (unless already changed)
            if ($menuBurger->getMenus() === $this) {
                $menuBurger->setMenus(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MenuTaille>
     */
    public function getMenuTailles(): Collection
    {
        return $this->menuTailles;
    }

    public function addMenuTaille(MenuTaille $menuTaille): self
    {
        if (!$this->menuTailles->contains($menuTaille)) {
            $this->menuTailles[] = $menuTaille;
            $menuTaille->setMenus($this);
        }

        return $this;
    }

    public function removeMenuTaille(MenuTaille $menuTaille): self
    {
        if ($this->menuTailles->removeElement($menuTaille)) {
            // set the owning side to null (unless already changed)
            if ($menuTaille->getMenus() === $this) {
                $menuTaille->setMenus(null);
            }
        } 

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
            $friteBoisson->setMenus($this);
        }

        return $this;
    }

    public function removeFriteBoisson(FriteBoisson $friteBoisson): self
    {
        if ($this->friteBoissons->removeElement($friteBoisson)) {
            // set the owning side to null (unless already changed)
            if ($friteBoisson->getMenus() === $this) {
                $friteBoisson->setMenus(null);
            }
        }

        return $this;
    }

    
}
