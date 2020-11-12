<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use Symfony\Component\Validator\Constraints as Assert;

trait IsVerifiedTrait
{
    /**
     * @Assert\NotNull
     * @Assert\Type("bool")
     * @ORM\Column(type="boolean")
     */
    private bool $isVerified;

    public function getIsVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}
