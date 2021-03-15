<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CompletedRoutineRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CompletedRoutineRepository::class)
 */
class CompletedRoutine
{
    use Traits\BlameableTrait;
    use Traits\IdTrait;
    use Traits\TimestampableTrait;
    use Traits\UuidTrait;

    /**
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="completedRoutines", targetEntity=Routine::class)
     */
    #[Assert\Valid(groups: ['system'])]
    private Routine $routine;

    /**
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="completedRoutines", targetEntity=User::class)
     */
    #[Assert\Valid(groups: ['system'])]
    private User $user;

    /**
     * @ORM\Column(nullable=true, type="string")
     */
    #[Assert\Length(groups: ['api', 'form', 'system'], max: 255)]
    #[Assert\Type('string', groups: ['api', 'form', 'system'])]
    #[Groups(['gdpr'])]
    private ?string $comment;

    /**
     * @ORM\Column(type="datetimetz_immutable")
     */
    #[Assert\NotBlank(groups: ['api', 'form', 'system'])]
    #[Assert\Type('DateTimeImmutable', groups: ['api', 'form', 'system'])]
    #[Groups(['gdpr', 'list'])]
    private ?DateTimeImmutable $date;

    /**
     * @ORM\Column(type="integer")
     */
    #[Assert\GreaterThanOrEqual(0, groups: ['api', 'form', 'system'])]
    #[Assert\LessThanOrEqual(1024, groups: ['api', 'form', 'system'])]
    #[Assert\NotBlank(groups: ['api', 'form', 'system'])]
    #[Assert\Type('int', groups: ['api', 'form', 'system'])]
    #[Groups(['gdpr', 'list'])]
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
