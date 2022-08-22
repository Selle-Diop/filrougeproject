<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name:"type", type:"string")]
#[ORM\DiscriminatorMap(["burger"=>"Burger","menu"=>"Menu","portionfrites"=>"PortionFrites","boisson"=>"Boisson"])]

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[ApiResource]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["burger:read:simple","burger:read:all","menu:simple","menu:read",'client:read','client:readItem'])]

    protected $id;

    #[Groups(["burger:read:simple","burger:read:all","write",'boisson:write','boisson:read',"menu:read","taille:read",'commande:simple','client:read','client:readItem'])]
    #[ORM\Column(type: 'string', length: 50)]
     #[Assert\NotBlank(
        message : "le nom est obligatoire"
     )] 

    protected $nom;

    #[Groups(["burger:read:simple","burger:read:all","write",'boisson:write','boisson:read',"menu:read",'taille:read','commande:simple','client:read','client:readItem'])]
    #[ORM\Column(type: 'float')]
    protected $prix;

    // #[Groups(["burger:read:all"])]
    #[ORM\Column(type: 'boolean')]
    protected $etat=true;
 
    

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'produit')]
    // #[Groups(["burger:read:all","write"])]
    protected $gestionnaire;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: LigneCommande::class)]
    private $ligneCommandes;


    #[Groups(["burger:read:simple","burger:read:all","write",'boisson:write','boisson:read',"menu:read","menu:simple",'client:read','client:readItem'])]
    #[ORM\Column(type: 'blob',nullable:true)]
    protected  $image;

    // #[UploadableField(mapping:"media_object", fileNameProperty:"filePath")]
     #[Groups(['write','boisson:write',"menu:simple","menu:read"])]
    #[UploadableField(mapping:"media_object", fileNameProperty:"filePath")]
    public ?File $file = null;

    public function __construct()
    {
        $this->ligneCommandes = new ArrayCollection();
    }




    

    

   

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }


    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self
    {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }

    /**
     * @return Collection<int, LigneCommande>
     */
    public function getLigneCommandes(): Collection
    {
        return $this->ligneCommandes;
    }

    public function addLigneCommande(LigneCommande $ligneCommande): self
    {
        if (!$this->ligneCommandes->contains($ligneCommande)) {
            $this->ligneCommandes[] = $ligneCommande;
            $ligneCommande->setProduit($this);
        }

        return $this;
    }

    public function removeLigneCommande(LigneCommande $ligneCommande): self
    {
        if ($this->ligneCommandes->removeElement($ligneCommande)) {
            // set the owning side to null (unless already changed)
            if ($ligneCommande->getProduit() === $this) {
                $ligneCommande->setProduit(null);
            }
        }

        return $this;
    }

    public function getImage()
    {
        
       if(is_resource($this->image)){
        return utf8_encode(base64_encode(stream_get_contents($this->image)));
       }elseif($this->image){
        return $this->image;
       }
        return null;
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }

    

    

   

   

    /**
     * Get the value of file
     */ 
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set the value of file
     *
     * @return  self
     */ 
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }
}
