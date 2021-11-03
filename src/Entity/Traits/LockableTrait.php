<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait LockableTrait
{
    #[Assert\Type('DateTimeImmutable', groups: ['system'])]
    #[ORM\Column(nullable: true, type: Types::DATETIMETZ_IMMUTABLE)]
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
