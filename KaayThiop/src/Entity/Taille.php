<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TailleRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TailleRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
             'normalization_context' => ['groups' => ['taille:read']],

        ],
        "post"=>[
            
            'denormalization_context' => ['groups' => ['taille:write']],


        ]
    ]
        
    
)]
class Taille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
     #[Groups(["menu:simple","menu:read",'taille:read'])]

    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
     #[Groups(['taille:write',"menu:read",'taille:read'])]

    private $libelle;

   

    #[ORM\OneToMany(mappedBy: 'tailles', targetEntity: MenuTaille::class)]
    private $menuTailles;
    #[ApiSubresource]

    #[Groups(['taille:read',"menu:read"])]
    #[ORM\OneToMany(mappedBy: 'taille', targetEntity: TailleBoisson::class)]
    private $tailleBoissons;


    public function __construct()
    {
        $this->menuTailles = new ArrayCollection();
        $this->tailleBoissons = new ArrayCollection();
        
    }

    

   

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

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
            $menuTaille->setTailles($this);
        }

        return $this;
    }

    public function removeMenuTaille(MenuTaille $menuTaille): self
    {
        if ($this->menuTailles->removeElement($menuTaille)) {
            // set the owning side to null (unless already changed)
            if ($menuTaille->getTailles() === $this) {
                $menuTaille->setTailles(null);
            }
        }

        return $this;
    }

    

   

   

    /**
     * @return Collection<int, TailleBoisson>
     */
    public function getTailleBoissons(): Collection
    {
        return $this->tailleBoissons;
    }

    public function addTailleBoisson(TailleBoisson $tailleBoisson): self
    {
        if (!$this->tailleBoissons->contains($tailleBoisson)) {
            $this->tailleBoissons[] = $tailleBoisson;
            $tailleBoisson->setTaille($this);
        }

        return $this;
    }

    public function removeTailleBoisson(TailleBoisson $tailleBoisson): self
    {
        if ($this->tailleBoissons->removeElement($tailleBoisson)) {
            // set the owning side to null (unless already changed)
            if ($tailleBoisson->getTaille() === $this) {
                $tailleBoisson->setTaille(null);
            }
        }

        return $this;
    }

    

    
}
