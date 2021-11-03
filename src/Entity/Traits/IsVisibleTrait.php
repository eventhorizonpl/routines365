<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait IsVisibleTrait
{
    #[Assert\NotNull(groups: ['system'])]
    #[Assert\Type('bool', groups: ['system'])]
    #[ORM\Column(type: Types::BOOLEAN)]
    protected bool $isVisible;

    public function getIsVisible(): ?bool
    {
        return $this->isVisible;
    }

    public function setIsVisible(bool $isVisible): self
    {
        $this->isVisible = $isVisible;

        return $this;
    }
}
