<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use DateTimeImmutable;
use Symfony\Component\Validator\Constraints as Assert;

trait IsCompletedTrait
{
    /**
     * @Assert\Type("DateTimeImmutable")
     * @ORM\Column(nullable=true, type="datetimetz_immutable")
     */
    protected ?DateTimeImmutable $completedAt;

    /**
     * @Assert\NotNull
     * @Assert\Type("bool")
     * @ORM\Column(type="boolean")
     */
    private bool $isCompleted;

    public function getCompletedAt(): ?DateTimeImmutable
    {
        return $this->completedAt;
    }

    public function setCompletedAt(?DateTimeImmutable $completedAt): self
    {
        $this->completedAt = $completedAt;

        return $this;
    }

    public function getIsCompleted(): ?bool
    {
        return $this->isCompleted;
    }

    public function setIsCompleted(bool $isCompleted): self
    {
        $this->isCompleted = $isCompleted;

        return $this;
    }
}
