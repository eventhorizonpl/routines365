<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CompletedRoutineRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CompletedRoutineRepository::class)
 */
class CompletedRoutine
{
    use Traits\IdTrait;
    use Traits\UuidTrait;
    use Traits\BlameableTrait;
    use Traits\TimestampableTrait;

    /**
     * @Assert\Valid(groups={"system"})
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="completedRoutines", targetEntity=Routine::class)
     */
    private Routine $routine;

    /**
     * @Assert\Valid(groups={"system"})
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="completedRoutines", targetEntity=User::class)
     */
    private User $user;

    /**
     * @Assert\Length(max = 255, groups={"system"})
     * @Assert\Type("string", groups={"system"})
     * @ORM\Column(nullable=true, type="string")
     */
    private ?string $comment;

    /**
     * @Assert\NotBlank(groups={"system"})
     * @Assert\Type("DateTimeImmutable", groups={"system"})
     * @ORM\Column(type="datetimetz_immutable")
     */
    private ?DateTimeImmutable $date;

    /**
     * @Assert\GreaterThanOrEqual(0, groups={"system"})
     * @Assert\LessThanOrEqual(1024, groups={"system"})
     * @Assert\NotBlank(groups={"system"})
     * @Assert\Type("int", groups={"system"})
     * @ORM\Column(type="integer")
     */
    private int $minutesDevoted;

    public function __construct()
    {
        $this->comment = null;
        $this->date = null;
    }

    public function __toString(): string
    {
        return $this->getUuid();
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

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

    public function getMinutesDevoted(): ?int
    {
        return $this->minutesDevoted;
    }

    public function setMinutesDevoted(int $minutesDevoted): self
    {
        $this->minutesDevoted = $minutesDevoted;

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
