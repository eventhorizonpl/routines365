<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait PositionTrait
{
    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\LessThanOrEqual(1024, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    #[ORM\Column(type: Types::INTEGER)]
    protected int $position;

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }
}
