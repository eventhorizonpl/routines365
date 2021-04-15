<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserQuestionnaireRepository;
use Doctrine\Common\Collections\{ArrayCollection, Collection};
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserQuestionnaireRepository::class)
 */
class UserQuestionnaire
{
    use Traits\BlameableTrait;
    use Traits\IdTrait;
    use Traits\IsCompletedTrait;
    use Traits\TimestampableTrait;
    use Traits\UuidTrait;

    /**
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="userQuestionnaires", targetEntity=Questionnaire::class)
     */
    #[Assert\Valid(groups: ['system'])]
    private Questionnaire $questionnaire;

    /**
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="userQuestionnaires", targetEntity=User::class)
     */
    #[Assert\Valid(groups: ['system'])]
    private User $user;

    /**
     * @ORM\OneToMany(fetch="EXTRA_LAZY", mappedBy="userQuestionnaire", orphanRemoval=true, targetEntity=UserQuestionnaireAnswer::class)
     */
    #[Groups(['gdpr'])]
    private Collection $userQuestionnaireAnswers;

    /**
     * @ORM\Column(type="boolean")
     */
    #[Assert\NotNull(groups: ['system'])]
    #[Assert\Type('bool', groups: ['system'])]
    #[Groups(['gdpr'])]
    private bool $isRewarded;

    public function __construct()
    {
        $this->isCompleted = false;
        $this->isRewarded = false;
        $this->userQuestionnaireAnswers = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getUuid();
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

    public function getIsRewarded(): ?bool
    {
        return $this->isRewarded;
    }

    public function setIsRewarded(bool $isRewarded): self
    {
        $this->isRewarded = $isRewarded;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function addUserQuestionnaireAnswer(UserQuestionnaireAnswer $userQuestionnaireAnswer): self
    {
        if (false === $this->userQuestionnaireAnswers->contains($userQuestionnaireAnswer)) {
            $this->userQuestionnaireAnswers->add($userQuestionnaireAnswer);
            $userQuestionnaireAnswer->setUserQuestionnaire($this);
        }

        return $this;
    }

    public function getUserQuestionnaireAnswer(Answer $answer): ?UserQuestionnaireAnswer
    {
        foreach ($this->userQuestionnaireAnswers as $userQuestionnaireAnswer) {
            if ($userQuestionnaireAnswer->getAnswer() === $answer) {
                return $userQuestionnaireAnswer;
            }
        }

        return null;
    }

    public function getUserQuestionnaireAnswers(): Collection
    {
        return $this->userQuestionnaireAnswers->filter(fn (UserQuestionnaireAnswer $userQuestionnaireAnswer) => null === $userQuestionnaireAnswer->getDeletedAt());
    }

    public function getUserQuestionnaireAnswersAll(): Collection
    {
        return $this->userQuestionnaireAnswers;
    }

    public function hasUserQuestionnaireAnswer(Answer $answer): bool
    {
        foreach ($this->userQuestionnaireAnswers as $userQuestionnaireAnswer) {
            if ($userQuestionnaireAnswer->getAnswer() === $answer) {
                return true;
            }
        }

        return false;
    }

    public function removeUserQuestionnaireAnswer(UserQuestionnaireAnswer $userQuestionnaireAnswer): self
    {
        if (true === $this->userQuestionnaireAnswers->contains($userQuestionnaireAnswer)) {
            $this->userQuestionnaireAnswers->removeElement($userQuestionnaireAnswer);
        }

        return $this;
    }
}
