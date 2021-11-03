<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CompletedRoutineRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CompletedRoutineRepository::class)]
class CompletedRoutine
{
    use Traits\BlameableTrait;
    use Traits\IdTrait;
    use Traits\TimestampableTrait;
    use Traits\UuidTrait;

    #[Assert\Valid(groups: ['system'])]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[ORM\ManyToOne(fetch: 'EXTRA_LAZY', inversedBy: 'completedRoutines', targetEntity: Routine::class)]
    private Routine $routine;

    #[Assert\Valid(groups: ['system'])]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[ORM\ManyToOne(fetch: 'EXTRA_LAZY', inversedBy: 'completedRoutines', targetEntity: User::class)]
    private User $user;

    #[Assert\Length(groups: ['form', 'system'], max: 255)]
    #[Assert\Type('string', groups: ['form', 'system'])]
    #[Groups(['gdpr'])]
    #[ORM\Column(nullable: true, type: Types::STRING)]
    private ?string $comment;

    #[Assert\NotBlank(groups: ['form', 'system'])]
    #[Assert\Type('DateTimeImmutable', groups: ['form', 'system'])]
    #[Groups(['gdpr'])]
    #[ORM\Column(type: Types::DATETIMETZ_IMMUTABLE)]
    private ?DateTimeImmutable $date;

    #[Assert\GreaterThanOrEqual(0, groups: ['form', 'system'])]
    #[Assert\LessThanOrEqual(1024, groups: ['form', 'system'])]
    #[Assert\NotBlank(groups: ['form', 'system'])]
    #[Assert\Type('int', groups: ['form', 'system'])]
    #[Groups(['gdpr'])]
    #[ORM\Column(type: Types::INTEGER)]
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
