<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

trait IsVerifiedTrait
{
    /**
     * @ORM\Column(type="boolean")
     */
    #[Assert\NotNull(groups: ['system'])]
    #[Assert\Type('bool', groups: ['system'])]
    #[Groups(['gdpr'])]
    protected bool $isVerified;

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
