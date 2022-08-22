<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\QuartierRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: QuartierRepository::class)]
#[ApiResource]
class Quartier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
     #[Groups(['zone:read'])]

    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
     #[Groups(['zone:read'])]

    private $nomQuartier;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $isQuartier;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'quartiers')]
    private $zone;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomQuartier(): ?string
    {
        return $this->nomQuartier;
    }

    public function setNomQuartier(?string $nomQuartier): self
    {
        $this->nomQuartier = $nomQuartier;

        return $this;
    }

    public function isIsQuartier(): ?bool
    {
        return $this->isQuartier;
    }

    public function setIsQuartier(?bool $isQuartier): self
    {
        $this->isQuartier = $isQuartier;

        return $this;
    }

    

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }
}
