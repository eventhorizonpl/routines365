<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Dto\{RoutineCollectionInput, RoutineCollectionOutput, RoutineItemInput, RoutineItemOutput};
use App\Enum\RoutineTypeEnum;
use App\Repository\RoutineRepository;
use App\Security\Voter\RoutineVoter;
use Doctrine\Common\Collections\{ArrayCollection, Collection};
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    collectionOperations: [
        'get' => [
            'output' => RoutineCollectionOutput::class,
        ],
        'post' => [
            'input' => RoutineCollectionInput::class,
            'output' => RoutineItemOutput::class,
        ],
    ],
    itemOperations: [
        'delete' => [
            'security' => 'is_granted("'.RoutineVoter::DELETE.'", object)',
        ],
        'get' => [
            'output' => RoutineItemOutput::class,
            'security' => 'is_granted("'.RoutineVoter::VIEW.'", object)',
        ],
        'patch' => [
            'input' => RoutineItemInput::class,
            'output' => RoutineItemOutput::class,
            'security' => 'is_granted("'.RoutineVoter::EDIT.'", object)',
        ],
        'put' => [
            'input' => RoutineItemInput::class,
            'output' => RoutineItemOutput::class,
            'security' => 'is_granted("'.RoutineVoter::EDIT.'", object)',
        ],
    ],
)]
#[ORM\Entity(repositoryClass: RoutineRepository::class)]
#[ORM\Index(name: 'type_idx', columns: ['type'])]
class Routine
{
    use Traits\BlameableTrait;
    use Traits\IdTrait;
    use Traits\IsEnabledTrait;
    use Traits\TimestampableTrait;
    use Traits\UuidTrait;

    #[ORM\OneToMany(fetch: 'EXTRA_LAZY', mappedBy: 'routine', orphanRemoval: true, targetEntity: CompletedRoutine::class)]
    #[ORM\OrderBy(['id' => 'ASC'])]
    private Collection $completedRoutines;

    #[ORM\OneToMany(fetch: 'EXTRA_LAZY', mappedBy: 'routine', orphanRemoval: true, targetEntity: Goal::class)]
    #[ORM\OrderBy(['name' => 'ASC'])]
    private Collection $goals;

    #[ORM\OneToMany(fetch: 'EXTRA_LAZY', mappedBy: 'routine', orphanRemoval: true, targetEntity: Note::class)]
    #[ORM\OrderBy(['id' => 'DESC'])]
    private Collection $notes;

    #[ORM\OneToMany(fetch: 'EXTRA_LAZY', mappedBy: 'routine', orphanRemoval: true, targetEntity: Reminder::class)]
    #[ORM\OrderBy(['nextDate' => 'ASC'])]
    private Collection $reminders;

    #[ORM\OneToMany(fetch: 'EXTRA_LAZY', mappedBy: 'routine', orphanRemoval: true, targetEntity: Reward::class)]
    #[ORM\OrderBy(['id' => 'DESC'])]
    private Collection $rewards;

    #[ORM\OneToMany(fetch: 'EXTRA_LAZY', mappedBy: 'routine', orphanRemoval: true, targetEntity: SentReminder::class)]
    private Collection $sentReminders;

    #[Assert\Valid(groups: ['system'])]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[ORM\ManyToOne(fetch: 'EXTRA_LAZY', inversedBy: 'routines', targetEntity: User::class)]
    private User $user;

    #[Assert\Length(groups: ['form', 'system'], max: 255)]
    #[Assert\Type('string', groups: ['form', 'system'])]
    #[Groups(['gdpr'])]
    #[ORM\Column(nullable: true, type: Types::STRING)]
    private ?string $description;

    #[Assert\Length(groups: ['form', 'system'], max: 64)]
    #[Assert\NotBlank(groups: ['form', 'system'])]
    #[Assert\Type('string', groups: ['form', 'system'])]
    #[Groups(['gdpr'])]
    #[ORM\Column(length: 64, type: Types::STRING)]
    private ?string $name;

    #[Assert\Choice(callback: 'getTypeValidationChoices', groups: ['form', 'system'])]
    #[Assert\Length(groups: ['form', 'system'], max: 16)]
    #[Assert\NotBlank(groups: ['form', 'system'])]
    #[Assert\Type('string', groups: ['form', 'system'])]
    #[Groups(['gdpr'])]
    #[ORM\Column(length: 16, type: Types::STRING)]
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
        $this->type = RoutineTypeEnum::HOBBY;
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
        return $this->completedRoutines->filter(fn (CompletedRoutine $completedRoutine) => null === $completedRoutine->getDeletedAt());
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

        return sprintf('%dh %dm', $totalMinutes / 3600, $totalMinutes / 60 % 60);
    }

    public function getCompletedRoutinesPercent(): int
    {
        $completedRoutines = $this->getCompletedRoutinesCount();
        $sentReminders = $this->getSentRemindersCount();

        if ($sentReminders > 0) {
            return (int) (($completedRoutines / $sentReminders) * 100);
        }

        return 0;
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
        return $this->goals->filter(fn (Goal $goal) => null === $goal->getDeletedAt());
    }

    public function getGoalsAll(): Collection
    {
        return $this->goals;
    }

    public function getGoalsCompleted(): Collection
    {
        return $this->goals->filter(fn (Goal $goal) => (true === $goal->getIsCompleted()) && (null === $goal->getDeletedAt()));
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
        }

        return 0;
    }

    public function getGoalsCount(): int
    {
        return $this->getGoals()->count();
    }

    public function getGoalsNotCompleted(): Collection
    {
        return $this->goals->filter(fn (Goal $goal) => (false === $goal->getIsCompleted()) && (null === $goal->getDeletedAt()));
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
        }

        return 0;
    }

    public function removeGoal(Goal $goal): self
    {
        if (true === $this->goals->contains($goal)) {
            $this->goals->removeElement($goal);
        }

        return $this;
    }

    public function getName(): ?string
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
        return $this->notes->filter(fn (Note $note) => null === $note->getDeletedAt());
    }

    public function getNotesAll(): Collection
    {
        return $this->notes;
    }

    public function getNotesCount(): int
    {
        return $this->getNotes()->count();
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
        return $this->reminders->filter(fn (Reminder $reminder) => null === $reminder->getDeletedAt());
    }

    public function getRemindersAll(): Collection
    {
        return $this->reminders;
    }

    public function getRemindersCount(): int
    {
        return $this->getReminders()->count();
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
        return $this->rewards->filter(fn (Reward $reward) => null === $reward->getDeletedAt());
    }

    public function getRewardsAll(): Collection
    {
        return $this->rewards;
    }

    public function getRewardsCount(): int
    {
        return $this->getRewards()->count();
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
        return $this->sentReminders->filter(fn (SentReminder $sentReminder) => null === $sentReminder->getDeletedAt());
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
        }

        return 0;
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
            RoutineTypeEnum::HOBBY => RoutineTypeEnum::HOBBY,
            RoutineTypeEnum::LEARNING => RoutineTypeEnum::LEARNING,
            RoutineTypeEnum::SPORT => RoutineTypeEnum::SPORT,
            RoutineTypeEnum::WORK => RoutineTypeEnum::WORK,
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
