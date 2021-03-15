<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserQuestionnaireAnswerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserQuestionnaireAnswerRepository::class)
 */
class UserQuestionnaireAnswer
{
    use Traits\BlameableTrait;
    use Traits\IdTrait;
    use Traits\TimestampableTrait;
    use Traits\UuidTrait;

    /**
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="userQuestionnaireAnswers", targetEntity=Answer::class)
     */
    #[Assert\Valid(groups: ['system'])]
    private ?Answer $answer;

    /**
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="userQuestionnaireAnswers", targetEntity=UserQuestionnaire::class)
     */
    #[Assert\Valid(groups: ['system'])]
    private UserQuestionnaire $userQuestionnaire;

    /**
     * @ORM\Column(nullable=true, type="string")
     */
    #[Assert\Length(groups: ['form', 'system'], max: 255)]
    #[Assert\Type('string', groups: ['form', 'system'])]
    #[Groups(['gdpr'])]
    private ?string $content;

    public function __construct()
    {
        $this->answer = null;
        $this->content = null;
    }

    public function __toString(): string
    {
        return $this->getUuid();
    }

    public function getAnswer(): ?Answer
    {
        return $this->answer;
    }

    public function setAnswer(Answer $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getUserQuestionnaire(): ?UserQuestionnaire
    {
        return $this->userQuestionnaire;
    }

    public function setUserQuestionnaire(UserQuestionnaire $userQuestionnaire): self
    {
        $this->userQuestionnaire = $userQuestionnaire;

        return $this;
    }
}
