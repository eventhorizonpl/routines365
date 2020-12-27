<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use Symfony\Component\Validator\Constraints as Assert;

trait IsEnabledTrait
{
    /**
     * @Assert\NotNull(groups={"system"})
     * @Assert\Type("bool", groups={"system"})
     * @ORM\Column(type="boolean")
     */
    protected bool $isEnabled;

    public function getIsEnabled(): ?bool
    {
        return $this->isEnabled;
    }

    public function setIsEnabled(bool $isEnabled): self
    {
        $this->isEnabled = $isEnabled;

        return $this;
    }
}
