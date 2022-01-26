<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\ReminderTypeEnum;
use App\Repository\ReminderRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\Common\Collections\{ArrayCollection, Collection};
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReminderRepository::class)]
#[ORM\Index(name: 'next_date_idx', columns: ['next_date'])]
#[ORM\Index(name: 'type_idx', columns: ['type'])]
class Reminder
{
    use Traits\BlameableTrait;
    use Traits\IdTrait;
    use Traits\IsEnabledTrait;
    use Traits\LockableTrait;
    use Traits\TimestampableTrait;
    use Traits\UuidTrait;

    #[ORM\OneToMany(fetch: 'EXTRA_LAZY', mappedBy: 'reminder', orphanRemoval: true, targetEntity: ReminderMessage::class)]
    private Collection $reminderMessages;

    #[ORM\OneToMany(fetch: 'EXTRA_LAZY', mappedBy: 'reminder', orphanRemoval: true, targetEntity: SentReminder::class)]
    private Collection $sentReminders;

    #[Assert\Valid(groups: ['system'])]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[ORM\ManyToOne(fetch: 'EXTRA_LAZY', inversedBy: 'reminders', targetEntity: Routine::class)]
    private Routine $routine;

    #[Assert\Valid(groups: ['system'])]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[ORM\ManyToOne(fetch: 'EXTRA_LAZY', inversedBy: 'reminders', targetEntity: User::class)]
    private User $user;

    #[Assert\NotBlank(groups: ['form', 'system'])]
    #[Assert\Type('DateTimeImmutable', groups: ['form', 'system'])]
    #[Groups(['gdpr'])]
    #[ORM\Column(type: Types::TIME_IMMUTABLE)]
    private DateTimeImmutable $hour;

    #[Assert\Choice(callback: 'getMinutesBeforeValidationChoices', groups: ['form', 'system'])]
    #[Assert\GreaterThanOrEqual(0, groups: ['form', 'system'])]
    #[Assert\LessThanOrEqual(60, groups: ['form', 'system'])]
    #[Assert\NotBlank(groups: ['form', 'system'])]
    #[Assert\Type('int', groups: ['form', 'system'])]
    #[Groups(['gdpr'])]
    #[ORM\Column(type: Types::INTEGER)]
    private int $minutesBefore;

    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('DateTimeImmutable', groups: ['system'])]
    #[Groups(['gdpr'])]
    #[ORM\Column(type: Types::DATETIMETZ_IMMUTABLE)]
    private ?DateTimeImmutable $nextDate;

    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('DateTimeImmutable', groups: ['system'])]
    #[Groups(['gdpr'])]
    #[ORM\Column(type: Types::DATETIMETZ_IMMUTABLE)]
    private ?DateTimeImmutable $nextDateLocalTime;

    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('DateTimeImmutable', groups: ['system'])]
    #[Groups(['gdpr'])]
    #[ORM\Column(type: Types::DATETIMETZ_IMMUTABLE)]
    private ?DateTimeImmutable $previousDate;

    #[Assert\NotNull(groups: ['form', 'system'])]
    #[Assert\Type('bool', groups: ['form', 'system'])]
    #[Groups(['gdpr'])]
    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $sendEmail;

    #[Assert\NotNull(groups: ['form', 'system'])]
    #[Assert\Type('bool', groups: ['form', 'system'])]
    #[Groups(['gdpr'])]
    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $sendMotivationalMessage;

    #[Assert\NotNull(groups: ['form', 'system'])]
    #[Assert\Type('bool', groups: ['form', 'system'])]
    #[Groups(['gdpr'])]
    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $sendSms;

    #[Assert\NotNull(groups: ['form', 'system'])]
    #[Assert\Type('bool', groups: ['form', 'system'])]
    #[Groups(['gdpr'])]
    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $sendToBrowser;

    #[Assert\Choice(callback: 'getTypeValidationChoices', groups: ['form', 'system'])]
    #[Assert\NotBlank(groups: ['form', 'system'])]
    #[Assert\Type(ReminderTypeEnum::class, groups: ['form', 'system'])]
    #[Groups(['gdpr'])]
    #[ORM\Column(enumType: ReminderTypeEnum::class, length: 10, type: Types::STRING)]
    private ReminderTypeEnum $type;

    public function __construct()
    {
        $this->isEnabled = true;
        $this->nextDate = null;
        $this->nextDateLocalTime = null;
        $this->previousDate = null;
        $this->reminderMessages = new ArrayCollection();
        $this->sendEmail = true;
        $this->sendMotivationalMessage = true;
        $this->sentReminders = new ArrayCollection();
        $this->sendSms = false;
        $this->sendToBrowser = false;
        $this->type = ReminderTypeEnum::DAILY;
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
        return $this->reminderMessages->filter(fn (ReminderMessage $reminderMessage) => null === $reminderMessage->getDeletedAt());
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
        $routineStartDate = DateTime::createFromImmutable($this->getNextDate());
        $routineStartDate->modify(sprintf(
            '+%d minutes',
            $this->getMinutesBefore()
        ));

        return DateTimeImmutable::createFromMutable($routineStartDate);
    }

    public function getRoutineStartDateLocalTime(): ?DateTimeImmutable
    {
        $routineStartDateLocalTime = DateTime::createFromImmutable($this->getNextDateLocalTime());
        $routineStartDateLocalTime->modify(sprintf(
            '+%d minutes',
            $this->getMinutesBefore()
        ));

        return DateTimeImmutable::createFromMutable($routineStartDateLocalTime);
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

    public function getSendToBrowser(): ?bool
    {
        return $this->sendToBrowser;
    }

    public function setSendToBrowser(bool $sendToBrowser): self
    {
        $this->sendToBrowser = $sendToBrowser;

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
        return $this->sentReminders->filter(fn (SentReminder $sentReminder) => null === $sentReminder->getDeletedAt());
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

    public function getType(): ?ReminderTypeEnum
    {
        return $this->type;
    }

    public static function getTypeFormChoices(): array
    {
        return [
            ReminderTypeEnum::DAILY->value => ReminderTypeEnum::DAILY->value,
            ReminderTypeEnum::MONDAY->value => ReminderTypeEnum::MONDAY->value,
            ReminderTypeEnum::TUESDAY->value => ReminderTypeEnum::TUESDAY->value,
            ReminderTypeEnum::WEDNESDAY->value => ReminderTypeEnum::WEDNESDAY->value,
            ReminderTypeEnum::THURSDAY->value => ReminderTypeEnum::THURSDAY->value,
            ReminderTypeEnum::FRIDAY->value => ReminderTypeEnum::FRIDAY->value,
            ReminderTypeEnum::SATURDAY->value => ReminderTypeEnum::SATURDAY->value,
            ReminderTypeEnum::SUNDAY->value => ReminderTypeEnum::SUNDAY->value,
        ];
    }

    public static function getTypeValidationChoices(): array
    {
        return [
            ReminderTypeEnum::DAILY,
            ReminderTypeEnum::MONDAY,
            ReminderTypeEnum::TUESDAY,
            ReminderTypeEnum::WEDNESDAY,
            ReminderTypeEnum::THURSDAY,
            ReminderTypeEnum::FRIDAY,
            ReminderTypeEnum::SATURDAY,
            ReminderTypeEnum::SUNDAY,
        ];
    }

    public function setType(ReminderTypeEnum $type): self
    {
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
