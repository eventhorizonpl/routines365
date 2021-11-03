<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use ApiPlatform\Core\Annotation\{ApiProperty, ApiResource};
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource]
trait IdTrait
{
    #[ApiProperty(identifier: false)]
    #[Assert\Type('int', groups: ['system'])]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Id]
    protected ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
