<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use Symfony\Component\Validator\Constraints as Assert;

trait IsCompletedTrait
{
    /**
     * @Assert\NotNull
     * @Assert\Type("bool")
     * @ORM\Column(type="boolean")
     */
    private bool $isCompleted;

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
