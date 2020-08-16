<?php

namespace App\Entity;

use App\Repository\KpiRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=KpiRepository::class)
 */
class Kpi
{
    use Traits\IdTrait;
    use Traits\UuidTrait;
    use Traits\TimestampableTrait;

    /**
     * @Assert\GreaterThanOrEqual(0)
     * @Assert\NotBlank
     * @Assert\Type("int")
     * @ORM\Column(type="integer")
     */
    private int $accountCounter;

    /**
     * @Assert\GreaterThanOrEqual(0)
     * @Assert\NotBlank
     * @Assert\Type("int")
     * @ORM\Column(type="integer")
     */
    private int $accountOperationCounter;

    /**
     * @Assert\NotBlank
     * @Assert\Type("DateTimeImmutable")
     * @ORM\Column(type="datetimetz_immutable")
     */
    private ?DateTimeImmutable $date;

    /**
     * @Assert\GreaterThanOrEqual(0)
     * @Assert\NotBlank
     * @Assert\Type("int")
     * @ORM\Column(type="integer")
     */
    private int $goalCounter;

    /**
     * @Assert\GreaterThanOrEqual(0)
     * @Assert\NotBlank
     * @Assert\Type("int")
     * @ORM\Column(type="integer")
     */
    private int $noteCounter;

    /**
     * @Assert\GreaterThanOrEqual(0)
     * @Assert\NotBlank
     * @Assert\Type("int")
     * @ORM\Column(type="integer")
     */
    private int $profileCounter;

    /**
     * @Assert\GreaterThanOrEqual(0)
     * @Assert\NotBlank
     * @Assert\Type("int")
     * @ORM\Column(type="integer")
     */
    private int $quoteCounter;

    /**
     * @Assert\GreaterThanOrEqual(0)
     * @Assert\NotBlank
     * @Assert\Type("int")
     * @ORM\Column(type="integer")
     */
    private int $reminderCounter;

    /**
     * @Assert\GreaterThanOrEqual(0)
     * @Assert\NotBlank
     * @Assert\Type("int")
     * @ORM\Column(type="integer")
     */
    private int $reminderMessageCounter;

    /**
     * @Assert\GreaterThanOrEqual(0)
     * @Assert\NotBlank
     * @Assert\Type("int")
     * @ORM\Column(type="integer")
     */
    private int $routineCounter;

    /**
     * @Assert\GreaterThanOrEqual(0)
     * @Assert\NotBlank
     * @Assert\Type("int")
     * @ORM\Column(type="integer")
     */
    private int $userCounter;

    public function __construct()
    {
        $this->accountCounter = 0;
        $this->accountOperationCounter = 0;
        $this->goalCounter = 0;
        $this->noteCounter = 0;
        $this->profileCounter = 0;
        $this->quoteCounter = 0;
        $this->reminderCounter = 0;
        $this->reminderMessageCounter = 0;
        $this->routineCounter = 0;
        $this->userCounter = 0;
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

    public function getRoutineCounter(): int
    {
        return $this->routineCounter;
    }

    public function setRoutineCounter(int $routineCounter): self
    {
        $this->routineCounter = $routineCounter;

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
}
