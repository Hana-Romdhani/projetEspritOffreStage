<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OffreRepository::class)]
class Offre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 5,max: 50,minMessage: 'Le nom de l"offre doit contenir au moins 5 caractères',maxMessage:'Le nom de l"offre doit contenir au plus 5 caractères'  )  ]
    #[Assert\NotBlank(message: "Veuillez remplir ce champ, s'il vous plaît")]
    private ?string $nomOffre = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Veuillez remplir ce champ, s'il vous plaît")]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: "La date de publication ne doit pas être nulle")]

    #[Assert\GreaterThanOrEqual("today", message: "La date de publication doit être supérieure ou égale à aujourd'hui")]
    private ?\DateTimeInterface $datePublication = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: "La date de clôture ne doit pas être nulle")]
    #[Assert\GreaterThanOrEqual(propertyPath: "datePublication", message: "La date de Cloture doit être supérieure ou égale à la date de clôture")]
    private ?\DateTimeInterface $dateCloture = null;



    #[ORM\ManyToMany(targetEntity: Competence::class)]
    private Collection $competences;

    #[ORM\OneToOne(inversedBy: 'offre', cascade: ['persist', 'remove'])]
    private ?Test $test = null;

    #[ORM\ManyToOne(inversedBy: 'offres')]
    #[ORM\JoinColumn(nullable: false, referencedColumnName:"Id_utilisateur")]

    private ?Utilisateur $UserIDOFFRE = null;

   
  



    public function __construct()
    {
        $this->competences = new ArrayCollection();
        // $this->UserList = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomOffre(): ?string
    {
        return $this->nomOffre;
    }

    public function setNomOffre(string $nomOffre): self
    {
        $this->nomOffre = $nomOffre;

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

    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->datePublication;
    }

    public function setDatePublication(\DateTimeInterface $datePublication): self
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    public function getDateCloture(): ?\DateTimeInterface
    {
        return $this->dateCloture;
    }

    public function setDateCloture(\DateTimeInterface $dateCloture): self
    {
        $this->dateCloture = $dateCloture;

        return $this;
    }

    /**
     * @return Collection<int, Competence>
     */
    public function getCompetences(): Collection
    {
        return $this->competences;
    }

    public function addCompetence(Competence $competence): self
    {
        if (!$this->competences->contains($competence)) {
            $this->competences->add($competence);
        }

        return $this;
    }

    public function removeCompetence(Competence $competence): self
    {
        $this->competences->removeElement($competence);

        return $this;
    }
    public function hasCompetence(Competence $competence): bool
    {
        return $this->competences->contains($competence);
    }

    public function getTest(): ?Test
    {
        return $this->test;
    }

    public function setTest(?Test $test): self
    {
        $this->test = $test;

        return $this;
    }

    public function getUserIDOFFRE(): ?Utilisateur
    {
        return $this->UserIDOFFRE;
    }

    public function setUserIDOFFRE(?Utilisateur $UserIDOFFRE): self
    {
        $this->UserIDOFFRE = $UserIDOFFRE;

        return $this;
    }


}
