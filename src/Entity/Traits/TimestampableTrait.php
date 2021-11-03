<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

trait TimestampableTrait
{
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('DateTimeImmutable', groups: ['system'])]
    #[Groups(['gdpr'])]
    #[ORM\Column(type: Types::DATETIMETZ_IMMUTABLE)]
    protected ?DateTimeImmutable $createdAt = null;

    #[Assert\Type('DateTimeImmutable', groups: ['system'])]
    #[Groups(['gdpr'])]
    #[ORM\Column(nullable: true, type: Types::DATETIMETZ_IMMUTABLE)]
    protected ?DateTimeImmutable $deletedAt = null;

    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('DateTimeImmutable', groups: ['system'])]
    #[Groups(['gdpr'])]
    #[ORM\Column(type: Types::DATETIMETZ_IMMUTABLE)]
    protected ?DateTimeImmutable $updatedAt = null;

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getDeletedAt(): ?DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?DateTimeImmutable $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
