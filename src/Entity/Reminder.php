<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ReminderRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ReminderRepository::class)
 * @ORM\Table(indexes={@ORM\Index(name="next_date_idx", columns={"next_date"}), @ORM\Index(name="type_idx", columns={"type"})})
 */
class Reminder
{
    use Traits\IdTrait;
    use Traits\UuidTrait;
    use Traits\IsEnabledTrait;
    use Traits\LockableTrait;
    use Traits\BlameableTrait;
    use Traits\TimestampableTrait;

    public const TYPE_DAILY = 'daily';
    public const TYPE_FRIDAY = 'friday';
    public const TYPE_MONDAY = 'monday';
    public const TYPE_SATURDAY = 'saturday';
    public const TYPE_SUNDAY = 'sunday';
    public const TYPE_THURSDAY = 'thursday';
    public const TYPE_TUESDAY = 'tuesday';
    public const TYPE_WEDNESDAY = 'wednesday';

    /**
     * @ORM\OneToMany(fetch="EXTRA_LAZY", mappedBy="reminder", orphanRemoval=true, targetEntity=ReminderMessage::class)
     */
    private Collection $reminderMessages;

    /**
     * @ORM\OneToMany(fetch="EXTRA_LAZY", mappedBy="reminder", orphanRemoval=true, targetEntity=SentReminder::class)
     */
    private Collection $sentReminders;

    /**
     * @Assert\Valid(groups={"system"})
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="reminders", targetEntity=Routine::class)
     */
    private Routine $routine;

    /**
     * @Assert\Valid(groups={"system"})
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="reminders", targetEntity=User::class)
     */
    private User $user;

    /**
     * @Assert\NotBlank(groups={"form", "system"})
     * @Assert\Type("DateTimeImmutable", groups={"form", "system"})
     * @Groups({"gdpr"})
     * @ORM\Column(type="time_immutable")
     */
    private DateTimeImmutable $hour;

    /**
     * @Assert\Choice(callback="getMinutesBeforeValidationChoices", groups={"form", "system"})
     * @Assert\GreaterThanOrEqual(0, groups={"form", "system"})
     * @Assert\LessThanOrEqual(60, groups={"form", "system"})
     * @Assert\NotBlank(groups={"form", "system"})
     * @Assert\Type("int", groups={"form", "system"})
     * @Groups({"gdpr"})
     * @ORM\Column(type="integer")
     */
    private int $minutesBefore;

    /**
     * @Assert\NotBlank(groups={"system"})
     * @Assert\Type("DateTimeImmutable", groups={"system"})
     * @Groups({"gdpr"})
     * @ORM\Column(type="datetimetz_immutable")
     */
    private ?DateTimeImmutable $nextDate;

    /**
     * @Assert\NotBlank(groups={"system"})
     * @Assert\Type("DateTimeImmutable", groups={"system"})
     * @Groups({"gdpr"})
     * @ORM\Column(type="datetimetz_immutable")
     */
    private ?DateTimeImmutable $nextDateLocalTime;

    /**
     * @Assert\NotBlank(groups={"system"})
     * @Assert\Type("DateTimeImmutable", groups={"system"})
     * @Groups({"gdpr"})
     * @ORM\Column(type="datetimetz_immutable")
     */
    private ?DateTimeImmutable $previousDate;

    /**
     * @Assert\NotNull(groups={"form", "system"})
     * @Assert\Type("bool", groups={"form", "system"})
     * @Groups({"gdpr"})
     * @ORM\Column(type="boolean")
     */
    private bool $sendEmail;

    /**
     * @Assert\NotNull(groups={"form", "system"})
     * @Assert\Type("bool", groups={"form", "system"})
     * @Groups({"gdpr"})
     * @ORM\Column(type="boolean")
     */
    private bool $sendMotivationalMessage;

    /**
     * @Assert\NotNull(groups={"form", "system"})
     * @Assert\Type("bool", groups={"form", "system"})
     * @Groups({"gdpr"})
     * @ORM\Column(type="boolean")
     */
    private bool $sendSms;

    /**
     * @Assert\Choice(callback="getTypeValidationChoices", groups={"form", "system"})
     * @Assert\Length(max = 10, groups={"form", "system"})
     * @Assert\NotBlank(groups={"form", "system"})
     * @Assert\Type("string", groups={"form", "system"})
     * @Groups({"gdpr"})
     * @ORM\Column(length=10, type="string")
     */
    private string $type;

    public function __construct()
    {
        $this->isEnabled = true;
        $this->nextDate = null;
        $this->nextDateLocalTime = null;
        $this->previousDate = null;
        $this->reminderMessages = new ArrayCollection();
        $this->sendEmail = true;
        $this->sentReminders = new ArrayCollection();
        $this->sendSms = false;
        $this->type = self::TYPE_DAILY;
    }

    public function __toString(): string
    {
        return $this->getUuid();
    }

    public function getHour(): ?DateTimeImmutable
    {
        return $this->hour;
    }

    public function setHour(DateTimeImmutable $hour): self
    {
        $this->hour = $hour;

        return $this;
    }

    public function getMinutesBefore(): ?int
    {
        return $this->minutesBefore;
    }

    public static function getMinutesBeforeFormChoices(): array
    {
        $minutesBefore = [];

        for ($i = 5; $i <= 30; $i += 5) {
            $minutesBefore[$i] = $i;
        }

        return $minutesBefore;
    }

    public static function getMinutesBeforeValidationChoices(): array
    {
        return array_keys(self::getMinutesBeforeFormChoices());
    }

    public function setMinutesBefore(int $minutesBefore): self
    {
        $this->minutesBefore = $minutesBefore;

        return $this;
    }

    public function getNextDate(): ?DateTimeImmutable
    {
        return $this->nextDate;
    }

    public function setNextDate(DateTimeImmutable $nextDate): self
    {
        $this->nextDate = $nextDate;

        return $this;
    }

    public function getNextDateLocalTime(): ?DateTimeImmutable
    {
        return $this->nextDateLocalTime;
    }

    public function setNextDateLocalTime(DateTimeImmutable $nextDateLocalTime): self
    {
        $this->nextDateLocalTime = $nextDateLocalTime;

        return $this;
    }

    public function getPreviousDate(): ?DateTimeImmutable
    {
        return $this->previousDate;
    }

    public function setPreviousDate(DateTimeImmutable $previousDate): self
    {
        $this->previousDate = $previousDate;

        return $this;
    }

    public function addReminderMessage(ReminderMessage $reminderMessage): self
    {
        if (false === $this->reminderMessages->contains($reminderMessage)) {
            $this->reminderMessages->add($reminderMessage);
            $reminderMessage->setReminder($this);
        }

        return $this;
    }

    public function getReminderMessages(): Collection
    {
        return $this->reminderMessages->filter(function (ReminderMessage $reminderMessage) {
            return null === $reminderMessage->getDeletedAt();
        });
    }

    public function getReminderMessagesAll(): Collection
    {
        return $this->reminderMessages;
    }

    public function removeReminderMessage(ReminderMessage $reminderMessage): self
    {
        if (true === $this->reminderMessages->contains($reminderMessage)) {
            $this->reminderMessages->removeElement($reminderMessage);
        }

        return $this;
    }

    public function getRoutine(): ?Routine
    {
        return $this->routine;
    }

    public function getRoutineStartDate(): ?DateTimeImmutable
    {
        $routineStartDate = DateTime::createFromImmutable($this->getNextDateLocalTime());
        $routineStartDate->modify('+'.$this->getMinutesBefore().' minutes');

        return DateTimeImmutable::createFromMutable($routineStartDate);
    }

    public function setRoutine(Routine $routine): self
    {
        $this->routine = $routine;

        return $this;
    }

    public function getSendEmail(): ?bool
    {
        return $this->sendEmail;
    }

    public function setSendEmail(bool $sendEmail): self
    {
        $this->sendEmail = $sendEmail;

        return $this;
    }

    public function getSendMotivationalMessage(): ?bool
    {
        return $this->sendMotivationalMessage;
    }

    public function setSendMotivationalMessage(bool $sendMotivationalMessage): self
    {
        $this->sendMotivationalMessage = $sendMotivationalMessage;

        return $this;
    }

    public function getSendSms(): ?bool
    {
        return $this->sendSms;
    }

    public function setSendSms(bool $sendSms): self
    {
        $this->sendSms = $sendSms;

        return $this;
    }

    public function addSentReminder(SentReminder $sentReminder): self
    {
        if (false === $this->sentReminders->contains($sentReminder)) {
            $this->sentReminders->add($sentReminder);
            $sentReminder->setReminder($this);
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
            self::TYPE_DAILY => self::TYPE_DAILY,
            self::TYPE_MONDAY => self::TYPE_MONDAY,
            self::TYPE_TUESDAY => self::TYPE_TUESDAY,
            self::TYPE_WEDNESDAY => self::TYPE_WEDNESDAY,
            self::TYPE_THURSDAY => self::TYPE_THURSDAY,
            self::TYPE_FRIDAY => self::TYPE_FRIDAY,
            self::TYPE_SATURDAY => self::TYPE_SATURDAY,
            self::TYPE_SUNDAY => self::TYPE_SUNDAY,
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
