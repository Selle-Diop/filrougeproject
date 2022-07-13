<?php

namespace App\Entity;

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
            "path"=>"/complement",
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
#[Assert\NotBlank(message:"Ce Champ est Obligatoire")]
    #[ORM\ManyToOne(targetEntity: PortionFrites::class, inversedBy: 'complement')]
    private $portionFrites;
#[Assert\NotBlank(message:"Ce Champ est Obligatoire")]

    #[ORM\ManyToOne(targetEntity: Boisson::class, inversedBy: 'complement')]
    private $boisson;

    public function getPortionFrites(): ?PortionFrites
    {
        return $this->portionFrites;
    }

    public function setPortionFrites(?PortionFrites $portionFrites): self
    {
        $this->portionFrites = $portionFrites;

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
}
