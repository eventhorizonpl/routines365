<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AnswerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AnswerRepository::class)
 */
class Answer
{
    use Traits\IdTrait;
    use Traits\UuidTrait;
    use Traits\IsEnabledTrait;
    use Traits\PositionTrait;
    use Traits\BlameableTrait;
    use Traits\TimestampableTrait;

    public const TYPE_DEFINED = 'defined';
    public const TYPE_OWN = 'own';

    /**
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="answers", targetEntity=Question::class)
     */
    #[Assert\Valid(groups: ['system'])]
    private Question $question;

    /**
     * @ORM\OneToMany(fetch="EXTRA_LAZY", mappedBy="answer", orphanRemoval=true, targetEntity=UserQuestionnaireAnswer::class)
     */
    private Collection $userQuestionnaireAnswers;

    /**
     * @ORM\Column(type="string")
     */
    #[Assert\Length(groups: ['form', 'system'], max: 255)]
    #[Assert\NotBlank(groups: ['form', 'system'])]
    #[Assert\Type('string', groups: ['form', 'system'])]
    private ?string $content;

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
        $this->isEnabled = true;
        $this->position = 0;
        $this->content = '';
        $this->type = self::TYPE_DEFINED;
        $this->userQuestionnaireAnswers = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getContent();
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(Question $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public static function getTypeFormChoices(): array
    {
        return [
            self::TYPE_DEFINED => self::TYPE_DEFINED,
            self::TYPE_OWN => self::TYPE_OWN,
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

    public function addUserQuestionnaireAnswer(UserQuestionnaireAnswer $userQuestionnaireAnswer): self
    {
        if (false === $this->userQuestionnaireAnswers->contains($userQuestionnaireAnswer)) {
            $this->userQuestionnaireAnswers->add($userQuestionnaireAnswer);
            $userQuestionnaireAnswer->setAnswer($this);
        }

        return $this;
    }

    public function getUserQuestionnaireAnswers(): Collection
    {
        return $this->userQuestionnaireAnswers->filter(function (UserQuestionnaireAnswer $userQuestionnaireAnswer) {
            return null === $userQuestionnaireAnswer->getDeletedAt();
        });
    }

    public function getUserQuestionnaireAnswersAll(): Collection
    {
        return $this->userQuestionnaireAnswers;
    }

    public function removeUserQuestionnaireAnswer(UserQuestionnaireAnswer $userQuestionnaireAnswer): self
    {
        if (true === $this->userQuestionnaireAnswers->contains($userQuestionnaireAnswer)) {
            $this->userQuestionnaireAnswers->removeElement($userQuestionnaireAnswer);
        }

        return $this;
    }
}
