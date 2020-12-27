<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use DateTimeImmutable;
use Symfony\Component\Validator\Constraints as Assert;

trait LockableTrait
{
    /**
     * @Assert\Type("DateTimeImmutable", groups={"system"})
     * @ORM\Column(nullable=true, type="datetimetz_immutable")
     */
    protected ?DateTimeImmutable $lockedAt = null;

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
