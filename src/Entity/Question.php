<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\QuestionTypeEnum;
use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\{ArrayCollection, Collection};
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=QuestionRepository::class)
 */
class Question
{
    use Traits\BlameableTrait;
    use Traits\IdTrait;
    use Traits\IsEnabledTrait;
    use Traits\PositionTrait;
    use Traits\TimestampableTrait;
    use Traits\UuidTrait;

    /**
     * @ORM\OneToMany(fetch="EXTRA_LAZY", mappedBy="question", orphanRemoval=true, targetEntity=Answer::class)
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private Collection $answers;

    /**
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="questions", targetEntity=Questionnaire::class)
     */
    #[Assert\Valid(groups: ['system'])]
    private Questionnaire $questionnaire;

    /**
     * @ORM\Column(type="string")
     */
    #[Assert\Length(groups: ['form', 'system'], max: 255)]
    #[Assert\NotBlank(groups: ['form', 'system'])]
    #[Assert\Type('string', groups: ['form', 'system'])]
    private ?string $title;

    /**
     * @ORM\Column(length=24, type="string")
     */
    #[Assert\Choice(callback: 'getTypeValidationChoices', groups: ['form', 'system'])]
    #[Assert\Length(groups: ['form', 'system'], max: 24)]
    #[Assert\NotBlank(groups: ['form', 'system'])]
    #[Assert\Type('string', groups: ['form', 'system'])]
    private string $type;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
        $this->isEnabled = true;
        $this->position = 0;
        $this->title = '';
        $this->type = QuestionTypeEnum::SINGLE_ANSWER;
    }

    public function __toString(): string
    {
        return $this->getTitle();
    }

    public function addAnswer(Answer $answer): self
    {
        if (false === $this->answers->contains($answer)) {
            $this->answers->add($answer);
            $answer->setQuestion($this);
        }

        return $this;
    }

    public function getAnswers(): Collection
    {
        return $this->answers->filter(fn (Answer $answer) => null === $answer->getDeletedAt());
    }

    public function getAnswersAll(): Collection
    {
        return $this->answers;
    }

    public function removeAnswer(Answer $answer): self
    {
        if (true === $this->answers->contains($answer)) {
            $this->answers->removeElement($answer);
        }

        return $this;
    }

    public function getQuestionnaire(): ?Questionnaire
    {
        return $this->questionnaire;
    }

    public function setQuestionnaire(Questionnaire $questionnaire): self
    {
        $this->questionnaire = $questionnaire;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public static function getTypeFormChoices(): array
    {
        return [
            QuestionTypeEnum::MULTIPLE_ANSWER => QuestionTypeEnum::MULTIPLE_ANSWER,
            QuestionTypeEnum::SINGLE_ANSWER => QuestionTypeEnum::SINGLE_ANSWER,
        ];
    }

    public static function getTypeValidationChoices(): array
    {
        return array_keys(self::getTypeFormChoices());
    }

    public function setType(string $type): self
    {
        if (!(\in_array($type, self::getTypeValidationChoices(), true))) {
            throw new InvalidArgumentException('Invalid type');
        }

        $this->type = $type;

        return $this;
    }
}
