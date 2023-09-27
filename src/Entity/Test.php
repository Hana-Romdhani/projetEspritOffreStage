<?php

namespace App\Entity;

use App\Repository\TestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: TestRepository::class)]
class Test
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'test', targetEntity: QuestionAnswer::class, cascade: ['persist', 'remove'])]
    private Collection $questionAnswers;

    #[ORM\OneToOne(mappedBy: 'test', cascade: ['persist', 'remove'])]
    private ?Offre $offre = null;


    public function __construct()
    {
        $this->questionAnswers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, QuestionAnswer>
     */
    public function getQuestionAnswers(): Collection
    {
        return $this->questionAnswers;
    }

    public function addQuestionAnswer(QuestionAnswer $questionAnswer): self
    {
        if (!$this->questionAnswers->contains($questionAnswer)) {
            $this->questionAnswers[] = $questionAnswer;
            $questionAnswer->setTest($this);
        }

        return $this;
    }

    public function removeQuestionAnswer(QuestionAnswer $questionAnswer): self
    {
        if ($this->questionAnswers->removeElement($questionAnswer)) {
            // set the owning side to null (unless already changed)
            if ($questionAnswer->getTest() === $this) {
                $questionAnswer->setTest(null);
            }
        }

        return $this;
    }

    public function setQuestionAnswers(Collection $questionAnswers): self
    {
        foreach ($questionAnswers as $questionAnswer) {
            $this->addQuestionAnswer($questionAnswer);
        }

        return $this;
    }
   
    

    private Collection $offres;
    public function getOffre(): ?Offre
    {
        return $this->offre;
    }

    public function setOffre(?Offre $offre): self
    {
        // unset the owning side of the relation if necessary
        if ($offre === null && $this->offre !== null) {
            $this->offre->setTest(null);
        }

        // set the owning side of the relation if necessary
        if ($offre !== null && $offre->getTest() !== $this) {
            $offre->setTest($this);
        }

        $this->offre = $offre;

        return $this;
    }
}

