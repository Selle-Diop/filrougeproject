<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BurgerRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
                'method' => 'get',
                'status' => Response::HTTP_OK,
                'normalization_context' => ['groups' => ['burger:read:simple']],
                
        ],
        
        
         "post"=>[
             'input_formats' => [
                'multipart' => ['multipart/form-data']
            ],
             'denormalization_context' => ['groups' => ['write']],
            'normalization_context'=> ['groups' => ['burger:read:all','burger:read:simple']],
             "security"=>"is_granted('ROLE_Gestionnaire')",
             "security_message"=>"Vous n'avez pas access à cette Ressource"
        ]
        ],                                                                                                                                                  
    itemOperations:
    [
        "put"=>[
            "security"=>"is_granted('ROLE_Gestionnaire')",
            "security_message"=>"Vous n'avez pas access à cette Ressource", 
                ],
        "get"=>[
            'method' => 'get',
            'status' => Response::HTTP_OK,
            'normalization_context' => ['groups' => ['burger:read:all']],
                ]
    ]
    
    
)]
class Burger extends Produit
{
    #[ORM\OneToMany(mappedBy: 'burgers', targetEntity: MenuBurger::class)]
    
    
    private $menuBurgers;

    public function __construct()
    {
        parent::__construct();
        $this->menuBurgers = new ArrayCollection();
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
            $menuBurger->setBurgers($this);
        }

        return $this;
    }

    public function removeMenuBurger(MenuBurger $menuBurger): self
    {
        if ($this->menuBurgers->removeElement($menuBurger)) {
            // set the owning side to null (unless already changed)
            if ($menuBurger->getBurgers() === $this) {
                $menuBurger->setBurgers(null);
            }
        }

        return $this;
    }
}
