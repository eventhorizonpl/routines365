<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\RoutineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=RoutineRepository::class)
 * @ORM\Table(indexes={@ORM\Index(name="type_idx", columns={"type"})})
 */
class Routine
{
    use Traits\IdTrait;
    use Traits\UuidTrait;
    use Traits\IsEnabledTrait;
    use Traits\BlameableTrait;
    use Traits\TimestampableTrait;

    public const TYPE_HOBBY = 'hobby';
    public const TYPE_LEARNING = 'learning';
    public const TYPE_SPORT = 'sport';
    public const TYPE_WORK = 'work';

    /**
     * @ORM\OneToMany(fetch="EXTRA_LAZY", mappedBy="routine", orphanRemoval=true, targetEntity=CompletedRoutine::class)
     * @ORM\OrderBy({"id" = "ASC"})
     */
    private Collection $completedRoutines;

    /**
     * @ORM\OneToMany(fetch="EXTRA_LAZY", mappedBy="routine", orphanRemoval=true, targetEntity=Goal::class)
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private Collection $goals;

    /**
     * @ORM\OneToMany(fetch="EXTRA_LAZY", mappedBy="routine", orphanRemoval=true, targetEntity=Note::class)
     * @ORM\OrderBy({"id" = "DESC"})
     */
    private Collection $notes;

    /**
     * @ORM\OneToMany(fetch="EXTRA_LAZY", mappedBy="routine", orphanRemoval=true, targetEntity=Reminder::class)
     * @ORM\OrderBy({"nextDate" = "ASC"})
     */
    private Collection $reminders;

    /**
     * @ORM\OneToMany(fetch="EXTRA_LAZY", mappedBy="routine", orphanRemoval=true, targetEntity=Reward::class)
     * @ORM\OrderBy({"id" = "DESC"})
     */
    private Collection $rewards;

    /**
     * @ORM\OneToMany(fetch="EXTRA_LAZY", mappedBy="routine", orphanRemoval=true, targetEntity=SentReminder::class)
     */
    private Collection $sentReminders;

    /**
     * @Assert\Valid(groups={"system"})
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="routines", targetEntity=User::class)
     */
    private User $user;

    /**
     * @Assert\Length(max = 255, groups={"form", "system"})
     * @Assert\Type("string", groups={"form", "system"})
     * @Groups({"gdpr"})
     * @ORM\Column(nullable=true, type="string")
     */
    private ?string $description;

    /**
     * @Assert\Length(max = 64, groups={"form", "system"})
     * @Assert\NotBlank(groups={"form", "system"})
     * @Assert\Type("string", groups={"form", "system"})
     * @Groups({"gdpr"})
     * @ORM\Column(length=64, type="string")
     */
    private ?string $name;

    /**
     * @Assert\Choice(callback="getTypeValidationChoices", groups={"form", "system"})
     * @Assert\Length(max = 16, groups={"form", "system"})
     * @Assert\NotBlank(groups={"form", "system"})
     * @Assert\Type("string", groups={"form", "system"})
     * @Groups({"gdpr"})
     * @ORM\Column(length=16, type="string")
     */
    private string $type;

    public function __construct()
    {
        $this->completedRoutines = new ArrayCollection();
        $this->description = null;
        $this->goals = new ArrayCollection();
        $this->isEnabled = true;
        $this->name = '';
        $this->notes = new ArrayCollection();
        $this->reminders = new ArrayCollection();
        $this->rewards = new ArrayCollection();
        $this->sentReminders = new ArrayCollection();
        $this->type = self::TYPE_HOBBY;
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    public function addCompletedRoutine(CompletedRoutine $completedRoutine): self
    {
        if (false === $this->completedRoutines->contains($completedRoutine)) {
            $this->completedRoutines->add($completedRoutine);
            $completedRoutine->setRoutine($this);
        }

        return $this;
    }

    public function getCompletedRoutines(): Collection
    {
        return $this->completedRoutines->filter(function (CompletedRoutine $completedRoutine) {
            return null === $completedRoutine->getDeletedAt();
        });
    }

    public function getCompletedRoutinesAll(): Collection
    {
        return $this->completedRoutines;
    }

    public function getCompletedRoutinesCount(): int
    {
        return $this->getCompletedRoutines()->count();
    }

    public function getCompletedRoutinesDevotedTime(): string
    {
        $totalMinutes = 0;

        foreach ($this->getCompletedRoutines() as $completedRoutine) {
            $totalMinutes += $completedRoutine->getMinutesDevoted();
        }

        $totalMinutes *= 60;

        return sprintf('%dd %dh %dm', $totalMinutes / 86400, $totalMinutes / 3600 % 24, $totalMinutes / 60 % 60);
    }

    public function getCompletedRoutinesPercent(): int
    {
        $completedRoutines = $this->getCompletedRoutinesCount();
        $sentReminders = $this->getSentRemindersCount();

        if ($sentReminders > 0) {
            return (int) (($completedRoutines / $sentReminders) * 100);
        } else {
            return 0;
        }
    }

    public function removeCompletedRoutine(CompletedRoutine $completedRoutine): self
    {
        if (true === $this->completedRoutines->contains($completedRoutine)) {
            $this->completedRoutines->removeElement($completedRoutine);
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function addGoal(Goal $goal): self
    {
        if (false === $this->goals->contains($goal)) {
            $this->goals->add($goal);
            $goal->setRoutine($this);
        }

        return $this;
    }

    public function getGoals(): Collection
    {
        return $this->goals->filter(function (Goal $goal) {
            return null === $goal->getDeletedAt();
        });
    }

    public function getGoalsAll(): Collection
    {
        return $this->goals;
    }

    public function getGoalsCompleted(): Collection
    {
        return $this->goals->filter(function (Goal $goal) {
            return (true === $goal->getIsCompleted()) && (null === $goal->getDeletedAt());
        });
    }

    public function getGoalsCompletedCount(): int
    {
        $goalsCompleted = 0;
        foreach ($this->goals as $goal) {
            if ((true === $goal->getIsCompleted()) && (null === $goal->getDeletedAt())) {
                ++$goalsCompleted;
            }
        }

        return $goalsCompleted;
    }

    public function getGoalsCompletedPercent(): int
    {
        $goalsCompleted = $this->getGoalsCompletedCount();
        $goalsNotCompleted = $this->getGoalsNotCompletedCount();

        $total = $goalsCompleted + $goalsNotCompleted;

        if ($total > 0) {
            return (int) (($goalsCompleted / $total) * 100);
        } else {
            return 0;
        }
    }

    public function getGoalsNotCompleted(): Collection
    {
        return $this->goals->filter(function (Goal $goal) {
            return (false === $goal->getIsCompleted()) && (null === $goal->getDeletedAt());
        });
    }

    public function getGoalsNotCompletedCount(): int
    {
        $goalsNotCompleted = 0;
        foreach ($this->goals as $goal) {
            if ((false === $goal->getIsCompleted()) && (null === $goal->getDeletedAt())) {
                ++$goalsNotCompleted;
            }
        }

        return $goalsNotCompleted;
    }

    public function getGoalsNotCompletedPercent(): int
    {
        $goalsCompleted = $this->getGoalsCompletedCount();
        $goalsNotCompleted = $this->getGoalsNotCompletedCount();

        $total = $goalsCompleted + $goalsNotCompleted;

        if ($total > 0) {
            return (int) (($goalsNotCompleted / $total) * 100);
        } else {
            return 0;
        }
    }

    public function removeGoal(Goal $goal): self
    {
        if (true === $this->goals->contains($goal)) {
            $this->goals->removeElement($goal);
        }

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function addNote(Note $note): self
    {
        if (false === $this->notes->contains($note)) {
            $this->notes->add($note);
            $note->setRoutine($this);
        }

        return $this;
    }

    public function getNotes(): Collection
    {
        return $this->notes->filter(function (Note $note) {
            return null === $note->getDeletedAt();
        });
    }

    public function getNotesAll(): Collection
    {
        return $this->notes;
    }

    public function removeNote(Note $note): self
    {
        if (true === $this->notes->contains($note)) {
            $this->notes->removeElement($note);
        }

        return $this;
    }

    public function addReminder(Reminder $reminder): self
    {
        if (false === $this->reminders->contains($reminder)) {
            $this->reminders->add($reminder);
            $reminder->setRoutine($this);
        }

        return $this;
    }

    public function getReminders(): Collection
    {
        return $this->reminders->filter(function (Reminder $reminder) {
            return null === $reminder->getDeletedAt();
        });
    }

    public function getRemindersAll(): Collection
    {
        return $this->reminders;
    }

    public function removeReminder(Reminder $reminder): self
    {
        if (true === $this->reminders->contains($reminder)) {
            $this->reminders->removeElement($reminder);
        }

        return $this;
    }

    public function addReward(Reward $reward): self
    {
        if (false === $this->rewards->contains($reward)) {
            $this->rewards->add($reward);
            $reward->setRoutine($this);
        }

        return $this;
    }

    public function getRewards(): Collection
    {
        return $this->rewards->filter(function (Reward $reward) {
            return null === $reward->getDeletedAt();
        });
    }

    public function getRewardsAll(): Collection
    {
        return $this->rewards;
    }

    public function removeReward(Reward $reward): self
    {
        if (true === $this->rewards->contains($reward)) {
            $this->rewards->removeElement($reward);
        }

        return $this;
    }

    public function addSentReminder(SentReminder $sentReminder): self
    {
        if (false === $this->sentReminders->contains($sentReminder)) {
            $this->sentReminders->add($sentReminder);
            $sentReminder->setRoutine($this);
        }

        return $this;
    }

    public function getSentReminders(): Collection
    {
        return $this->sentReminders->filter(function (SentReminder $sentReminder) {
            return null === $sentReminder->getDeletedAt();
        });
    }

    public function getSentRemindersAll(): Collection
    {
        return $this->sentReminders;
    }

    public function getSentRemindersCount(): int
    {
        return $this->getSentReminders()->count();
    }

    public function getSentRemindersPercent(): int
    {
        $completedRoutines = $this->getCompletedRoutinesCount();
        $sentReminders = $this->getSentRemindersCount();

        if ($sentReminders > 0) {
            return (int) ((($sentReminders / $sentReminders) * 100) - $this->getCompletedRoutinesPercent());
        } else {
            return 0;
        }
    }

    public function removeSentReminder(SentReminder $sentReminder): self
    {
        if (true === $this->sentReminders->contains($sentReminder)) {
            $this->sentReminders->removeElement($sentReminder);
        }

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public static function getTypeFormChoices(): array
    {
        return [
            self::TYPE_HOBBY => self::TYPE_HOBBY,
            self::TYPE_LEARNING => self::TYPE_LEARNING,
            self::TYPE_SPORT => self::TYPE_SPORT,
            self::TYPE_WORK => self::TYPE_WORK,
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
}
