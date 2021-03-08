<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserKpiRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserKpiRepository::class)
 * @ORM\Table(indexes={@ORM\Index(name="type_idx", columns={"type"})})
 */
class UserKpi
{
    use Traits\IdTrait;
    use Traits\UuidTrait;
    use Traits\TimestampableTrait;

    public const TYPE_ANNUALLY = 'annually';
    public const TYPE_DAILY = 'daily';
    public const TYPE_MONTHLY = 'monthly';
    public const TYPE_WEEKLY = 'weekly';

    /**
     * @ORM\OneToOne(fetch="EXTRA_LAZY", mappedBy="previousUserKpi", targetEntity=UserKpi::class)
     */
    #[Assert\Valid(groups: ['system'])]
    private ?UserKpi $nextUserKpi = null;

    /**
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     * @ORM\OneToOne(fetch="EXTRA_LAZY", inversedBy="nextUserKpi", targetEntity=UserKpi::class)
     */
    #[Assert\Valid(groups: ['system'])]
    private ?UserKpi $previousUserKpi = null;

    /**
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="userKpis", targetEntity=User::class)
     */
    #[Assert\Valid(groups: ['system'])]
    private User $user;

    /**
     * @ORM\Column(type="integer")
     */
    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    private int $accountOperationCounter;

    /**
     * @ORM\Column(type="integer")
     */
    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    private int $awardedRewardCounter;

    /**
     * @ORM\Column(type="integer")
     */
    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    private int $completedGoalCounter;

    /**
     * @ORM\Column(type="integer")
     */
    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    private int $completedProjectCounter;

    /**
     * @ORM\Column(type="integer")
     */
    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    private int $completedRoutineCounter;

    /**
     * @ORM\Column(type="integer")
     */
    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    private int $contactCounter;

    /**
     * @ORM\Column(type="integer")
     */
    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    private int $efficiency11;

    /**
     * @ORM\Column(type="datetimetz_immutable")
     */
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('DateTimeImmutable', groups: ['system'])]
    private ?DateTimeImmutable $date;

    /**
     * @ORM\Column(type="integer")
     */
    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    private int $goalCounter;

    /**
     * @ORM\Column(type="integer")
     */
    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    private int $noteCounter;

    /**
     * @ORM\Column(type="integer")
     */
    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    private int $projectCounter;

    /**
     * @ORM\Column(type="integer")
     */
    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    private int $reminderCounter;

    /**
     * @ORM\Column(type="integer")
     */
    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    private int $rewardCounter;

    /**
     * @ORM\Column(type="integer")
     */
    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    private int $routineCounter;

    /**
     * @ORM\Column(type="integer")
     */
    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    private int $savedEmailCounter;

    /**
     * @ORM\Column(length=8, type="string")
     */
    #[Assert\Choice(callback: 'getTypeValidationChoices', groups: ['system'])]
    #[Assert\Length(groups: ['system'], max: 8)]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('string', groups: ['system'])]
    private string $type;

    /**
     * @ORM\Column(type="integer")
     */
    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    private int $userQuestionnaireCounter;

    public function __construct()
    {
        $this->accountOperationCounter = 0;
        $this->awardedRewardCounter = 0;
        $this->completedGoalCounter = 0;
        $this->completedProjectCounter = 0;
        $this->completedRoutineCounter = 0;
        $this->contactCounter = 0;
        $this->efficiency11 = 0;
        $this->goalCounter = 0;
        $this->noteCounter = 0;
        $this->projectCounter = 0;
        $this->reminderCounter = 0;
        $this->rewardCounter = 0;
        $this->routineCounter = 0;
        $this->savedEmailCounter = 0;
        $this->userQuestionnaireCounter = 0;
    }

    public function __toString(): string
    {
        return $this->getUuid();
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

    public function getAwardedRewardCounter(): int
    {
        return $this->awardedRewardCounter;
    }

    public function setAwardedRewardCounter(int $awardedRewardCounter): self
    {
        $this->awardedRewardCounter = $awardedRewardCounter;

        return $this;
    }

    public function getCompletedGoalCounter(): int
    {
        return $this->completedGoalCounter;
    }

    public function setCompletedGoalCounter(int $completedGoalCounter): self
    {
        $this->completedGoalCounter = $completedGoalCounter;

        return $this;
    }

    public function getCompletedProjectCounter(): int
    {
        return $this->completedProjectCounter;
    }

    public function setCompletedProjectCounter(int $completedProjectCounter): self
    {
        $this->completedProjectCounter = $completedProjectCounter;

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

    public function getEfficiency11(): int
    {
        return $this->efficiency11;
    }

    public function setEfficiency11(int $efficiency11): self
    {
        $this->efficiency11 = $efficiency11;

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

    public function getNextUserKpi(): ?UserKpi
    {
        return $this->nextUserKpi;
    }

    public function setNextUserKpi(?UserKpi $nextUserKpi): self
    {
        $this->nextUserKpi = $nextUserKpi;

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

    public function getPreviousUserKpi(): ?UserKpi
    {
        return $this->previousUserKpi;
    }

    public function setPreviousUserKpi(?UserKpi $previousUserKpi): self
    {
        $this->previousUserKpi = $previousUserKpi;

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

    public function getReminderCounter(): int
    {
        return $this->reminderCounter;
    }

    public function setReminderCounter(int $reminderCounter): self
    {
        $this->reminderCounter = $reminderCounter;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public static function getTypeFormChoices(): array
    {
        return [
            self::TYPE_ANNUALLY => self::TYPE_ANNUALLY,
            self::TYPE_DAILY => self::TYPE_DAILY,
            self::TYPE_MONTHLY => self::TYPE_MONTHLY,
            self::TYPE_WEEKLY => self::TYPE_WEEKLY,
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

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
}
