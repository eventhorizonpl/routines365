<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use DateTimeImmutable;
use Symfony\Component\Validator\Constraints as Assert;

trait LockableTrait
{
    /**
     * @Assert\Type("DateTimeImmutable")
     * @ORM\Column(nullable=true, type="datetimetz_immutable")
     */
    protected $lockedAt;

    public function getLockedAt(): ?DateTimeImmutable
    {
        return $this->lockedAt;
    }

    public function setLockedAt(?DateTimeImmutable $lockedAt): self
    {
        $this->lockedAt = $lockedAt;

        return $this;
    }
}
