<?php

namespace App\Entity;

use App\Repository\SpecialiteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SpecialiteRepository::class)]

class Specialite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
     #[ORM\Column(name: 'id_specialite')]
    private ?int $idSpecialite=null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "ce champs est obligatoire")]
    #[Assert\Length(min: 2, max: 225, exactMessage: "votre domaine  ne contient pas {{ limit }} caractères.")]

    private ?string  $domaine=null;

    public function getIdSpecialite(): ?int
    {
        return $this->idSpecialite;
    }

    public function getDomaine(): ?string
    {
        return $this->domaine;
    }

    public function setDomaine(string $domaine): self
    {
        $this->domaine = $domaine;

        return $this;
    }


}
