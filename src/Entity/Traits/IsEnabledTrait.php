<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use Symfony\Component\Validator\Constraints as Assert;

trait IsEnabledTrait
{
    /**
     * @Assert\NotNull
     * @Assert\Type("bool")
     * @ORM\Column(type="boolean")
     */
    private bool $isEnabled;

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
