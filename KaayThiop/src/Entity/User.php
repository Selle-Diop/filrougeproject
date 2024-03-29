<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use App\Controller\EmailValidateAction;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
 #[ApiResource(       
    collectionOperations:[
        "get",
        "newVerb" =>[
            "method"=>"PATCH",
            'deserialize'=>false,
            'path' =>'users/validate/{token}',
            'controller' => EmailValidateAction::class
        ],
    
    "post_register" => [
        "method"=>"post",
        'path'=>'/register',
        'normalization_context' => ['groups' => ['user:read:simple']]
],
]
    
)] 
 

#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name:"role", type:"string")]
#[ORM\DiscriminatorMap(["gestionnaire"=>"Gestionnaire","client"=>"Client","livreur"=>"Livreur"])]

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["burger:read:all","write","user:read:simple",'client:read','client:readItem',"livreur","livreurI",'commande:simple'])]
    protected $id;

    #[Groups(["burger:read:all","user:read:simple",'commande:simple','client:read','client:readItem'])]
    #[ORM\Column(type: 'string', length: 180, unique: true)]
    protected $email;

    #[ORM\Column(type: 'json')]
    protected $roles = [];

    #[ORM\Column(type: 'string',nullable:true)]
    protected $password;

    #[Groups(["user:read:simple",'commande:simple','client:read','client:readItem',"livreur","livreurI",'livreur:read'])]
    #[ORM\Column(type: 'string', length: 50)]
    protected $nomComplet;

    #[ORM\Column(type: 'boolean',options:["default"=>'1'] )]
    protected $etat="1";

    #[ORM\Column(type: 'string', length: 255)]
    protected $token;

    #[ORM\Column(type: 'boolean')]
    protected $isEnable;
    
    public function __construct ()
    {
        $this->isEnable ="false";
        $this->generateToken();
    }
    public function generateToken()
    {
        $this->expireAT= new \DateTime("+1 day");
        $this->token =rtrim(str_replace(['+', '/', '='], ['-', '_', ''], base64_encode(random_bytes(128))));
    }

    #[ORM\Column(type: 'datetime')]
    protected $expireAT;

   


    #[SerializedName("password")]
    protected $PlainPassword;

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_VISITEUR';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNomComplet(): ?string
    {
        return $this->nomComplet;
    }

    public function setNomComplet(string $nomComplet): self
    {
        $this->nomComplet = $nomComplet;

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

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function isIsEnable(): ?bool
    {
        return $this->isEnable;
    }

    public function setIsEnable(bool $isEnable): self
    {
        $this->isEnable = $isEnable;

        return $this;
    }

    public function getExpireAT(): ?\DateTimeInterface
    {
        return $this->expireAT;
    }

    public function setExpireAT(\DateTimeInterface $expireAT): self
    {
        $this->expireAT = $expireAT;

        return $this;
    }

    

    public function getPlainPassword(): ?string
    {
        return $this->PlainPassword;
    }

    public function setPlainPassword(string $PlainPassword): self
    {
        $this->PlainPassword = $PlainPassword;

        return $this;
    }
}
