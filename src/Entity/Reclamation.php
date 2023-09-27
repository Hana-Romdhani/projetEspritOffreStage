<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateReclamation = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Veuillez remplir ce champ, s'il vous plaît")]
    #[Assert\Length(min:10,max: 50,minMessage: 'Description doit contenir au moins 5 caractères',maxMessage:'Description doit contenir au plus 5 caractères'  )  ]
    private ?string $description = null;

    #[ORM\Column(length: 20)]
    private ?string $etat = null;

    #[ORM\Column]
    private ?string $user;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Reponse $reponse = null;

    private string $rep = '';

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $test = null; 

    #[ORM\ManyToOne(inversedBy: 'reclamations')]
    #[ORM\JoinColumn(nullable: false, referencedColumnName:"Id_utilisateur")]
 
    private ?Utilisateur $useridid = null;

    /**
     * @return string
     */
    public function getRep(): string
    {
        return $this->rep;
    }

    /**
     * @param string $rep
     */
    public function setRep(string $rep): void
    {
        $this->rep = $rep;
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?String
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     */
    public function setUser(?string $user): void
    {
        $this->user =$user;
        // Create a new DateTime object
        $dateReclamation = new \DateTime();

// Get the date portion of the DateTime object using the format() method
        $dateString = $dateReclamation->format('Y-m-d');

        $this->dateReclamation = new \DateTime($dateString);
    }



    public function getDateReclamation(): ?\DateTimeInterface
    {
        return $this->dateReclamation;
    }

    public function setDateReclamation(\DateTimeInterface $dateReclamation): self
    {
        $this->dateReclamation = $dateReclamation;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getReponse(): ?Reponse
    {
        return $this->reponse;
    }

    public function setReponse(?Reponse $reponse): self
    {
        $this->reponse = $reponse;

        return $this;
    }

    public function getTest(): ?\DateTimeInterface
    {
        return $this->test;
    }

    public function setTest(?\DateTimeInterface $test): self
    {
        $this->test = $test;

        return $this;
    }

    public function getUseridid(): ?Utilisateur
    {
        return $this->useridid;
    }

    public function setUseridid(?Utilisateur $useridid): self
    {
        $this->useridid = $useridid;

        return $this;
    }



}
