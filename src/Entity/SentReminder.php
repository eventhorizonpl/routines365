<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\SentReminderRepository;
use Doctrine\Common\Collections\{ArrayCollection, Collection};
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SentReminderRepository::class)
 */
class SentReminder
{
    use Traits\IdTrait;
    use Traits\TimestampableTrait;
    use Traits\UuidTrait;

    /**
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="sentReminders", targetEntity=Reminder::class)
     */
    #[Assert\Valid(groups: ['system'])]
    private Reminder $reminder;

    /**
     * @ORM\OneToMany(fetch="EXTRA_LAZY", mappedBy="sentReminder", orphanRemoval=true, targetEntity=ReminderMessage::class)
     */
    private Collection $reminderMessages;

    /**
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="sentReminders", targetEntity=Routine::class)
     */
    #[Assert\Valid(groups: ['system'])]
    private Routine $routine;

    public function __construct()
    {
        $this->reminderMessages = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getUuid();
    }

    public function getReminder(): ?Reminder
    {
        return $this->reminder;
    }

    public function setReminder(Reminder $reminder): self
    {
        $this->reminder = $reminder;

        return $this;
    }

    public function addReminderMessage(ReminderMessage $reminderMessage): self
    {
        if (false === $this->reminderMessages->contains($reminderMessage)) {
            $this->reminderMessages->add($reminderMessage);
            $reminderMessage->setSentReminder($this);
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

    public function setRoutine(Routine $routine): self
    {
        $this->routine = $routine;

        return $this;
    }
}
