<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use ApiPlatform\Core\Annotation\{ApiProperty, ApiResource};
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource]
trait UuidTrait
{
    #[ApiProperty(identifier: true)]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Uuid(groups: ['Default', 'system'])]
    #[Groups(['gdpr'])]
    #[ORM\Column(type: Types::GUID, unique: true)]
    protected ?string $uuid = null;

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }
}
