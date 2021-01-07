<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserQuestionnaireAnswerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserQuestionnaireAnswerRepository::class)
 */
class UserQuestionnaireAnswer
{
    use Traits\IdTrait;
    use Traits\UuidTrait;
    use Traits\BlameableTrait;
    use Traits\TimestampableTrait;

    /**
     * @Assert\Valid(groups={"system"})
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="userQuestionnaireAnswers", targetEntity=Answer::class)
     */
    private Answer $answer;

    /**
     * @Assert\Valid(groups={"system"})
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="userQuestionnaireAnswers", targetEntity=UserQuestionnaire::class)
     */
    private UserQuestionnaire $userQuestionnaire;

    /**
     * @Assert\Length(max = 255, groups={"form", "system"})
     * @Assert\Type("string", groups={"form", "system"})
     * @ORM\Column(nullable=true, type="string")
     */
    private ?string $content;

    public function __construct()
    {
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
