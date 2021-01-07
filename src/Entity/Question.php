<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=QuestionRepository::class)
 */
class Question
{
    use Traits\IdTrait;
    use Traits\UuidTrait;
    use Traits\IsEnabledTrait;
    use Traits\PositionTrait;
    use Traits\BlameableTrait;
    use Traits\TimestampableTrait;

    public const TYPE_MULTIPLE_ANSWER = 'multiple_answer';
    public const TYPE_SINGLE_ANSWER = 'single_answer';

    /**
     * @ORM\OneToMany(fetch="EXTRA_LAZY", mappedBy="question", orphanRemoval=true, targetEntity=Answer::class)
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private Collection $answers;

    /**
     * @Assert\Valid(groups={"system"})
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="questions", targetEntity=Questionnaire::class)
     */
    private Questionnaire $questionnaire;

    /**
     * @Assert\Length(max = 255, groups={"form", "system"})
     * @Assert\NotBlank(groups={"form", "system"})
     * @Assert\Type("string", groups={"form", "system"})
     * @ORM\Column(type="string")
     */
    private string $title;

    /**
     * @Assert\Choice(callback="getTypeValidationChoices", groups={"form", "system"})
     * @Assert\Length(max = 24, groups={"form", "system"})
     * @Assert\NotBlank(groups={"form", "system"})
     * @Assert\Type("string", groups={"form", "system"})
     * @ORM\Column(length=24, type="string")
     */
    private string $type;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
        $this->isEnabled = true;
        $this->position = 0;
        $this->title = '';
        $this->type = self::TYPE_SINGLE_ANSWER;
    }

    public function __toString(): string
    {
        return $this->getTitle();
    }

    public function addAnswer(Answer $answer): self
    {
        if (false === $this->answers->contains($answer)) {
            $this->answers->add($answer);
            $answer->setAnswernaire($this);
        }

        return $this;
    }

    public function getAnswers(): Collection
    {
        return $this->answers->filter(function (Answer $answer) {
            return null === $answer->getDeletedAt();
        });
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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
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
            self::TYPE_MULTIPLE_ANSWER => self::TYPE_MULTIPLE_ANSWER,
            self::TYPE_SINGLE_ANSWER => self::TYPE_SINGLE_ANSWER,
        ];
    }

    public static function getTypeValidationChoices(): array
    {
        return array_keys(self::getTypeFormChoices());
    }

    public function setType(string $type): self
    {
        if (!(in_array($type, self::getTypeValidationChoices()))) {
            throw new InvalidArgumentException('Invalid type');
        }

        $this->type = $type;

        return $this;
    }
}
