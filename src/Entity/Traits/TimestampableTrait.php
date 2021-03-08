<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use DateTimeImmutable;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

trait TimestampableTrait
{
    /**
     * @Groups({"gdpr"})
     * @ORM\Column(type="datetimetz_immutable")
     */
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('DateTimeImmutable', groups: ['system'])]
    protected ?DateTimeImmutable $createdAt = null;

    /**
     * @ORM\Column(nullable=true, type="datetimetz_immutable")
     * @Groups({"gdpr"})
     */
    #[Assert\Type('DateTimeImmutable', groups: ['system'])]
    protected ?DateTimeImmutable $deletedAt = null;

    /**
     * @Groups({"gdpr"})
     * @ORM\Column(type="datetimetz_immutable")
     */
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('DateTimeImmutable', groups: ['system'])]
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
