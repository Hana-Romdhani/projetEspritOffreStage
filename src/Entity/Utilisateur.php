<?php

namespace App\Entity;
use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]

class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', name:'Id_utilisateur')]
    #[Groups("utilisateur:read")]

    private ?int $idUtilisateur = null;

   

    #[ORM\Column]
    #[Assert\NotBlank(message: "ce champs est obligatoire")]
    #[Assert\Length(min: 2, max: 225, exactMessage: "votre nom ne contient pas {{ limit }} caractères.")]
    #[Groups("utilisateur:read")]

    private string $nom='' ;

    #[ORM\Column(length: 255, nullable :true)]
    #[Assert\Length(min: 2, minMessage:"Votre prenom ne contient pas {{ limit }} caractères.")]
    #[Groups("utilisateur:read")]

    private ?string $prenom=null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:" ce champs est obligatoire")]
    #[Assert\Email(message:" ce email '{{value}}' est non valide")]
    #[Assert\Length(max: 100, maxMessage: "L'email ne peut pas faire plus de 180 caractères")]
    #[Groups("utilisateur:read")]

    
    private ?string $email='';

   
    #[ORM\Column(length: 255, name:'pwd')]
    //#[Assert\Length(min: 8, max: 225, exactMessage: "")]
    //#[Assert\Length(min: 8, minMessage:"Le mot de passe doit faire au moins 8 caractères")]
     //#[Assert\NotBlank(message: "Le mot de passe ne peut pas être vide")]
    // #[Assert\Regex(pattern: '/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{6,})/', message: "Le mot de passe doit contenir au moins 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial")]
    #[Groups("utilisateur:read")]

    private ?string $password='';

     #[ORM\Column(length: 255)]
     #[Assert\Length(min: 8, max: 8, exactMessage: "Le numéro de téléphone doit faire 8 caractères")]
     #[Assert\Regex(pattern: '/^[0-9]{8}$/', message: "Le numéro de téléphone n'est pas valide")]
     #[Assert\NotBlank(message: "Le numéro de téléphone ne peut pas être vide")]
     #[Groups("utilisateur:read")]
     
     private ?string $numeroTel='';

     #[ORM\Column(length: 255)]
     #[Assert\Length(min: 2, max: 100, minMessage: "L'adresse doit faire au moins 2 caractères", maxMessage: "La ville ne peut pas faire plus de 100 caractères")]
     #[Assert\NotBlank(message: "La ville ne peut pas être vide")]
     #[Groups("utilisateur:read")]

     private ?string $address='';

     #[ORM\Column(length: 255, name:'role')]
    //  #[Assert\NotBlank(message:" ce champs est obligatoire")]
    #[Groups("utilisateur:read")]


     private ?string $roles='';
     
     #[ORM\Column(length: 255, name:'url_image')]
     #[Groups("utilisateur:read")]

     private string $urlImage='';

     #[Assert\NotBlank(message: "La ville ne peut pas être vide")]
     #[ORM\Column(type: Types::DATETIME_MUTABLE)]
     #[Groups("utilisateur:read")]

    private ?\DateTimeInterface $date ;

    #[ORM\Column]
    #[Assert\NotBlank(message:" ce champs est obligatoire")]
    

    private ?bool $isdelete = true;
    
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable :true)]
    #[Groups("utilisateur:read")]

    private ?\DateTimeInterface $datederniereconnx;

    #[ORM\Column(length: 255, nullable :true)]
    #[Groups("utilisateur:read")]

    private ?string $domaineDeCompetence=null;

  

    #[ORM\Column(length: 255, nullable :true)]
    #[Groups("utilisateur:read")]

    private ?string $portfolio;

    #[ORM\Column(length: 255, nullable :true)]
    #[Groups("utilisateur:read")]

    private ?string $siteweb=null;

    #[ORM\Column(length: 255, nullable :true)]
    #[Groups("utilisateur:read")]

    private ?string $gender=null;

    #[ORM\Column(length: 255, nullable :true)]

    #[Groups("utilisateur:read")]

    private ?string  $description=null;

    #[ORM\Column(length: 255, nullable :true)]
    #[Groups("utilisateur:read")]

    private ?string $formeJuridique=null;


    #[ORM\ManyToOne(targetEntity: Specialite::class, inversedBy: 'utilisateurs')]
    #[ORM\JoinColumn(name: 'specialite_id', referencedColumnName: 'id_specialite')]

    private ?Specialite $refSpecialite=null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    

   

    #[ORM\OneToMany(mappedBy: 'useridid', targetEntity: Reclamation::class)]
    private Collection $reclamations;

    #[ORM\OneToMany(mappedBy: 'UserIDOFFRE', targetEntity: Offre::class)]
   
    

    private Collection $offres;


   

    // #[ORM\ManyToOne(inversedBy: 'user_id')]
    // private ?Participation $participation = null;

    //#[ORM\OneToMany(mappedBy: 'isuser', targetEntity: Post::class, orphanRemoval: true)]
   // private Collection $posts;



    public function __construct()
    {
        $this->date = new \DateTimeImmutable();
        $this->reclamations = new ArrayCollection();
        $this->offres = new ArrayCollection();
    }










    public function getIdUtilisateur(): ?int
    {
        return $this->idUtilisateur;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
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
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
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

    public function getNumeroTel(): ?string
    {
        return $this->numeroTel;
    }

    public function setNumeroTel(string $numeroTel): self
    {
        $this->numeroTel = $numeroTel;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->roles;
    }
   
   public function setRole(string $role): self
    {
        $this->roles= $role;

        return $this;
    }
       
    public function getRoles(): array
    {
       

         return [$this->getRole()];;
    }
   
    public function setRoles(string $roles): self
    {
        $this->roles = $roles;

        return $this;
    }






/**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }



    public function getUrlImage(): ?string
    {
        return $this->urlImage;
    }

    public function setUrlImage(string $urlImage): self
    {
        $this->urlImage = $urlImage;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {  
        return $this->date;
    }

    // public function setDate(\DateTimeImmutable $date): self
    // {
    //     $this->date = $date;

    //     return $this;
    // }
    public function setDate($date)
    {
        $this->date = $date;
    }
    public function isIsdelete(): ?bool
    {
        return $this->isdelete;
    }

    public function setIsdelete(bool $isdelete): self
    {
        $this->isdelete = $isdelete;

        return $this;
    }

    public function getDatederniereconnx(): ?\DateTimeInterface
    {
        return $this->datederniereconnx;
    }

    public function setDatederniereconnx(?\DateTimeInterface $datederniereconnx): self
    {
        $this->datederniereconnx = $datederniereconnx;

        return $this;
    }

    public function getDomaineDeCompetence(): ?string
    {
        return $this->domaineDeCompetence;
    }

    public function setDomaineDeCompetence(?string $domaineDeCompetence): self
    {
        $this->domaineDeCompetence = $domaineDeCompetence;

        return $this;
    }

   

    public function getPortfolio(): ?string
    {
        return $this->portfolio;
    }

    public function setPortfolio(?string $portfolio): self
    {
        $this->portfolio = $portfolio;

        return $this;
    }

    public function getSiteweb(): ?string
    {
        return $this->siteweb;
    }

    public function setSiteweb(?string $siteweb): self
    {
        $this->siteweb = $siteweb;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getFormeJuridique(): ?string
    {
        return $this->formeJuridique;
    }

    public function setFormeJuridique(?string $formeJuridique): self
    {
        $this->formeJuridique = $formeJuridique;

        return $this;
    }

    public function getRefSpecialite(): ?Specialite
    {
        return $this->refSpecialite;
    }

    public function setRefSpecialite(?Specialite $refSpecialite): self
    {
        $this->refSpecialite = $refSpecialite;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

   

    // /**
    //  * @return Collection<int, Post>
    //  */
    // public function getPosts(): Collection
    // {
    //     return $this->posts;
    // }

    // public function addPost(Post $post): self
    // {
    //     if (!$this->posts->contains($post)) {
    //         $this->posts->add($post);
    //         $post->setIsuser($this);
    //     }

    //     return $this;
    // }

    // public function removePost(Post $post): self
    // {
    //     if ($this->posts->removeElement($post)) {
    //         // set the owning side to null (unless already changed)
    //         if ($post->getIsuser() === $this) {
    //             $post->setIsuser(null);
    //         }
    //     }

    //     return $this;
    // }

   
  
    // /**
    //  * @return Collection<int, Reclamation>
    //  */
    // public function getReclamations(): Collection
    // {
    //     return $this->reclamations;
    // }

    // public function addReclamation(Reclamation $reclamation): self
    // {
    //     if (!$this->reclamations->contains($reclamation)) {
    //         $this->reclamations->add($reclamation);
    //         $reclamation->setUseridid($this);
    //     }

    //     return $this;
    // }

    // public function removeReclamation(Reclamation $reclamation): self
    // {
    //     if ($this->reclamations->removeElement($reclamation)) {
    //         // set the owning side to null (unless already changed)
    //         if ($reclamation->getUseridid() === $this) {
    //             $reclamation->setUseridid(null);
    //         }
    //     }

    //     return $this;
    // }

    // /**
    //  * @return Collection<int, Offre>
    //  */
    // public function getOffres(): Collection
    // {
    //     return $this->offres;
    // }

    // public function addOffre(Offre $offre): self
    // {
    //     if (!$this->offres->contains($offre)) {
    //         $this->offres->add($offre);
    //         $offre->setUserIDOFFRE($this);
    //     }

    //     return $this;
    // }

    // public function removeOffre(Offre $offre): self
    // {
    //     if ($this->offres->removeElement($offre)) {
    //         // set the owning side to null (unless already changed)
    //         if ($offre->getUserIDOFFRE() === $this) {
    //             $offre->setUserIDOFFRE(null);
    //         }
    //     }

    //     return $this;
    // }

  
}
