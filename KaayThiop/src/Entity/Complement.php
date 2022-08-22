<?php

namespace App\Entity;

use App\Entity\Taille;
use App\Entity\Produit;
use Doctrine\ORM\Mapping as ORM;
use App\DataProvider\ComplementProvider;
use App\Repository\ComplementRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;
#[Entity(repositoryClass: ComplementRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            "method"=> "GET",
           " normalization_context"=>['groups' => ['complement:read:simple']],
            
            "srccat"=>ComplementProvider::class

        ]  

        ],
    itemOperations:[]
)]
class Complement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
//  #[Assert\NotBlank(message:"Ce Champ est Obligatoire")]
//     #[ORM\ManyToOne(targetEntity: PortionFrites::class, inversedBy: 'complement')]
//     private $portionFrites;
// #[Assert\NotBlank(message:"Ce Champ est Obligatoire")]

//     #[ORM\ManyToOne(targetEntity: Taille::class, inversedBy: 'complement')]
//     private $taille;

    public function getPortionFrites(): ?PortionFrites
    {
        return $this->portionFrites;
    }

    public function setPortionFrites(?PortionFrites $portionFrites): self
    {
        $this->portionFrites = $portionFrites;

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
}
