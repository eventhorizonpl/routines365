<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\QuestionnaireRepository;
use Doctrine\Common\Collections\{ArrayCollection, Collection};
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=QuestionnaireRepository::class)
 */
class Questionnaire
{
    use Traits\BlameableTrait;
    use Traits\IdTrait;
    use Traits\IsEnabledTrait;
    use Traits\TimestampableTrait;
    use Traits\UuidTrait;

    /**
     * @ORM\OneToMany(fetch="EXTRA_LAZY", mappedBy="questionnaire", orphanRemoval=true, targetEntity=Question::class)
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private Collection $questions;

    /**
     * @ORM\OneToMany(fetch="EXTRA_LAZY", mappedBy="questionnaire", orphanRemoval=true, targetEntity=UserQuestionnaire::class)
     */
    private Collection $userQuestionnaires;

    /**
     * @ORM\Column(nullable=true, type="string")
     */
    #[Assert\Length(groups: ['form', 'system'], max: 255)]
    #[Assert\Type('string', groups: ['form', 'system'])]
    private ?string $description;

    /**
     * @ORM\Column(type="string")
     */
    #[Assert\Length(groups: ['form', 'system'], max: 255)]
    #[Assert\NotBlank(groups: ['form', 'system'])]
    #[Assert\Type('string', groups: ['form', 'system'])]
    private ?string $title;

    public function __construct()
    {
        $this->description = '';
        $this->isEnabled = false;
        $this->questions = new ArrayCollection();
        $this->title = '';
        $this->userQuestionnaires = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getTitle();
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

    public function addQuestion(Question $question): self
    {
        if (false === $this->questions->contains($question)) {
            $this->questions->add($question);
            $question->setQuestionnaire($this);
        }

        return $this;
    }

    public function getQuestions(): Collection
    {
        return $this->questions->filter(fn (Question $question) => null === $question->getDeletedAt());
    }

    public function getQuestionsAll(): Collection
    {
        return $this->questions;
    }

    public function removeQuestion(Question $question): self
    {
        if (true === $this->questions->contains($question)) {
            $this->questions->removeElement($question);
        }

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function addUserQuestionnaire(UserQuestionnaire $userQuestionnaire): self
    {
        if (false === $this->userQuestionnaires->contains($userQuestionnaire)) {
            $this->userQuestionnaires->add($userQuestionnaire);
            $userQuestionnaire->setQuestionnaire($this);
        }

        return $this;
    }

    public function getUserQuestionnaires(): Collection
    {
        return $this->userQuestionnaires->filter(fn (UserQuestionnaire $userQuestionnaire) => null === $userQuestionnaire->getDeletedAt());
    }

    public function getUserQuestionnairesAll(): Collection
    {
        return $this->userQuestionnaires;
    }

    public function removeUserQuestionnaire(UserQuestionnaire $userQuestionnaire): self
    {
        if (true === $this->userQuestionnaires->contains($userQuestionnaire)) {
            $this->userQuestionnaires->removeElement($userQuestionnaire);
        }

        return $this;
    }
}
