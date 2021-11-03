<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\KpiRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: KpiRepository::class)]
class Kpi
{
    use Traits\IdTrait;
    use Traits\TimestampableTrait;
    use Traits\UuidTrait;

    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    #[ORM\Column(type: Types::INTEGER)]
    private int $accountCounter;

    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    #[ORM\Column(type: Types::INTEGER)]
    private int $accountOperationCounter;

    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    #[ORM\Column(type: Types::INTEGER)]
    private int $achievementCounter;

    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    #[ORM\Column(type: Types::INTEGER)]
    private int $answerCounter;

    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    #[ORM\Column(type: Types::INTEGER)]
    private int $completedRoutineCounter;

    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    #[ORM\Column(type: Types::INTEGER)]
    private int $contactCounter;

    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('DateTimeImmutable', groups: ['system'])]
    #[ORM\Column(type: Types::DATETIMETZ_IMMUTABLE)]
    private ?DateTimeImmutable $date;

    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    #[ORM\Column(type: Types::INTEGER)]
    private int $goalCounter;

    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    #[ORM\Column(type: Types::INTEGER)]
    private int $noteCounter;

    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    #[ORM\Column(type: Types::INTEGER)]
    private int $profileCounter;

    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    #[ORM\Column(type: Types::INTEGER)]
    private int $projectCounter;

    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    #[ORM\Column(type: Types::INTEGER)]
    private int $promotionCounter;

    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    #[ORM\Column(type: Types::INTEGER)]
    private int $questionCounter;

    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    #[ORM\Column(type: Types::INTEGER)]
    private int $questionnaireCounter;

    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    #[ORM\Column(type: Types::INTEGER)]
    private int $quoteCounter;

    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    #[ORM\Column(type: Types::INTEGER)]
    private int $reminderCounter;

    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    #[ORM\Column(type: Types::INTEGER)]
    private int $reminderMessageCounter;

    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    #[ORM\Column(type: Types::INTEGER)]
    private int $retentionCounter;

    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    #[ORM\Column(type: Types::INTEGER)]
    private int $rewardCounter;

    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    #[ORM\Column(type: Types::INTEGER)]
    private int $routineCounter;

    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    #[ORM\Column(type: Types::INTEGER)]
    private int $savedEmailCounter;

    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    #[ORM\Column(type: Types::INTEGER)]
    private int $sentReminderCounter;

    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    #[ORM\Column(type: Types::INTEGER)]
    private int $userCounter;

    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    #[ORM\Column(type: Types::INTEGER)]
    private int $userKpiCounter;

    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    #[ORM\Column(type: Types::INTEGER)]
    private int $userKytCounter;

    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    #[ORM\Column(type: Types::INTEGER)]
    private int $userQuestionnaireCounter;

    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    #[ORM\Column(type: Types::INTEGER)]
    private int $userQuestionnaireAnswerCounter;

    public function __construct()
    {
        $this->accountCounter = 0;
        $this->accountOperationCounter = 0;
        $this->achievementCounter = 0;
        $this->answerCounter = 0;
        $this->completedRoutineCounter = 0;
        $this->contactCounter = 0;
        $this->goalCounter = 0;
        $this->noteCounter = 0;
        $this->profileCounter = 0;
        $this->projectCounter = 0;
        $this->promotionCounter = 0;
        $this->questionCounter = 0;
        $this->questionnaireCounter = 0;
        $this->quoteCounter = 0;
        $this->reminderCounter = 0;
        $this->reminderMessageCounter = 0;
        $this->retentionCounter = 0;
        $this->rewardCounter = 0;
        $this->routineCounter = 0;
        $this->savedEmailCounter = 0;
        $this->sentReminderCounter = 0;
        $this->userCounter = 0;
        $this->userKpiCounter = 0;
        $this->userKytCounter = 0;
        $this->userQuestionnaireCounter = 0;
        $this->userQuestionnaireAnswerCounter = 0;
    }

    public function __toString(): string
    {
        return $this->getUuid();
    }

    public function getAccountCounter(): int
    {
        return $this->accountCounter;
    }

    public function setAccountCounter(int $accountCounter): self
    {
        $this->accountCounter = $accountCounter;

        return $this;
    }

    public function getAccountOperationCounter(): int
    {
        return $this->accountOperationCounter;
    }

    public function setAccountOperationCounter(int $accountOperationCounter): self
    {
        $this->accountOperationCounter = $accountOperationCounter;

        return $this;
    }

    public function getAchievementCounter(): int
    {
        return $this->achievementCounter;
    }

    public function setAchievementCounter(int $achievementCounter): self
    {
        $this->achievementCounter = $achievementCounter;

        return $this;
    }

    public function getAnswerCounter(): int
    {
        return $this->answerCounter;
    }

    public function setAnswerCounter(int $answerCounter): self
    {
        $this->answerCounter = $answerCounter;

        return $this;
    }

    public function getCompletedRoutineCounter(): int
    {
        return $this->completedRoutineCounter;
    }

    public function setCompletedRoutineCounter(int $completedRoutineCounter): self
    {
        $this->completedRoutineCounter = $completedRoutineCounter;

        return $this;
    }

    public function getContactCounter(): int
    {
        return $this->contactCounter;
    }

    public function setContactCounter(int $contactCounter): self
    {
        $this->contactCounter = $contactCounter;

        return $this;
    }

    public function getDate(): ?DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(DateTimeImmutable $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getGoalCounter(): int
    {
        return $this->goalCounter;
    }

    public function setGoalCounter(int $goalCounter): self
    {
        $this->goalCounter = $goalCounter;

        return $this;
    }

    public function getNoteCounter(): int
    {
        return $this->noteCounter;
    }

    public function setNoteCounter(int $noteCounter): self
    {
        $this->noteCounter = $noteCounter;

        return $this;
    }

    public function getProfileCounter(): int
    {
        return $this->profileCounter;
    }

    public function setProfileCounter(int $profileCounter): self
    {
        $this->profileCounter = $profileCounter;

        return $this;
    }

    public function getProjectCounter(): int
    {
        return $this->projectCounter;
    }

    public function setProjectCounter(int $projectCounter): self
    {
        $this->projectCounter = $projectCounter;

        return $this;
    }

    public function getPromotionCounter(): int
    {
        return $this->promotionCounter;
    }

    public function setPromotionCounter(int $promotionCounter): self
    {
        $this->promotionCounter = $promotionCounter;

        return $this;
    }

    public function getQuestionCounter(): int
    {
        return $this->questionCounter;
    }

    public function setQuestionCounter(int $questionCounter): self
    {
        $this->questionCounter = $questionCounter;

        return $this;
    }

    public function getQuestionnaireCounter(): int
    {
        return $this->questionnaireCounter;
    }

    public function setQuestionnaireCounter(int $questionnaireCounter): self
    {
        $this->questionnaireCounter = $questionnaireCounter;

        return $this;
    }

    public function getQuoteCounter(): int
    {
        return $this->quoteCounter;
    }

    public function setQuoteCounter(int $quoteCounter): self
    {
        $this->quoteCounter = $quoteCounter;

        return $this;
    }

    public function getReminderCounter(): int
    {
        return $this->reminderCounter;
    }

    public function setReminderCounter(int $reminderCounter): self
    {
        $this->reminderCounter = $reminderCounter;

        return $this;
    }

    public function getReminderMessageCounter(): int
    {
        return $this->reminderMessageCounter;
    }

    public function setReminderMessageCounter(int $reminderMessageCounter): self
    {
        $this->reminderMessageCounter = $reminderMessageCounter;

        return $this;
    }

    public function getRetentionCounter(): int
    {
        return $this->retentionCounter;
    }

    public function setRetentionCounter(int $retentionCounter): self
    {
        $this->retentionCounter = $retentionCounter;

        return $this;
    }

    public function getRewardCounter(): int
    {
        return $this->rewardCounter;
    }

    public function setRewardCounter(int $rewardCounter): self
    {
        $this->rewardCounter = $rewardCounter;

        return $this;
    }

    public function getRoutineCounter(): int
    {
        return $this->routineCounter;
    }

    public function setRoutineCounter(int $routineCounter): self
    {
        $this->routineCounter = $routineCounter;

        return $this;
    }

    public function getSavedEmailCounter(): int
    {
        return $this->savedEmailCounter;
    }

    public function setSavedEmailCounter(int $savedEmailCounter): self
    {
        $this->savedEmailCounter = $savedEmailCounter;

        return $this;
    }

    public function getSentReminderCounter(): int
    {
        return $this->sentReminderCounter;
    }

    public function setSentReminderCounter(int $sentReminderCounter): self
    {
        $this->sentReminderCounter = $sentReminderCounter;

        return $this;
    }

    public function getUserCounter(): int
    {
        return $this->userCounter;
    }

    public function setUserCounter(int $userCounter): self
    {
        $this->userCounter = $userCounter;

        return $this;
    }

    public function getUserKpiCounter(): int
    {
        return $this->userKpiCounter;
    }

    public function setUserKpiCounter(int $userKpiCounter): self
    {
        $this->userKpiCounter = $userKpiCounter;

        return $this;
    }

    public function getUserKytCounter(): int
    {
        return $this->userKytCounter;
    }

    public function setUserKytCounter(int $userKytCounter): self
    {
        $this->userKytCounter = $userKytCounter;

        return $this;
    }

    public function getUserQuestionnaireCounter(): int
    {
        return $this->userQuestionnaireCounter;
    }

    public function setUserQuestionnaireCounter(int $userQuestionnaireCounter): self
    {
        $this->userQuestionnaireCounter = $userQuestionnaireCounter;

        return $this;
    }

    public function getUserQuestionnaireAnswerCounter(): int
    {
        return $this->userQuestionnaireAnswerCounter;
    }

    public function setUserQuestionnaireAnswerCounter(int $userQuestionnaireAnswerCounter): self
    {
        $this->userQuestionnaireAnswerCounter = $userQuestionnaireAnswerCounter;

        return $this;
    }
}
