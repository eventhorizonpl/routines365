<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use DateTimeImmutable;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

trait IsCompletedTrait
{
    /**
     * @ORM\Column(nullable=true, type="datetimetz_immutable")
     */
    #[Assert\Type('DateTimeImmutable', groups: ['system'])]
    #[Groups(['gdpr'])]
    protected ?DateTimeImmutable $completedAt = null;

    /**
     * @ORM\Column(type="boolean")
     */
    #[Assert\NotNull(groups: ['system'])]
    #[Assert\Type('bool', groups: ['system'])]
    #[Groups(['gdpr'])]
    protected bool $isCompleted;

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
