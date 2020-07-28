<?php

namespace App\Entity\Traits;

use DateTimeImmutable;
use Symfony\Component\Validator\Constraints as Assert;

trait TimestampableTrait
{
    /**
     * @Assert\NotBlank(groups={"system"})
     * @Assert\Type("DateTimeImmutable")
     * @ORM\Column(type="datetimetz_immutable")
     */
    protected $createdAt;

    /**
     * @Assert\Type("DateTimeImmutable")
     * @ORM\Column(type="datetimetz_immutable", nullable=true)
     */
    protected $deletedAt;

    /**
     * @Assert\NotBlank(groups={"system"})
     * @Assert\Type("DateTimeImmutable")
     * @ORM\Column(type="datetimetz_immutable")
     */
    protected $updatedAt;

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
