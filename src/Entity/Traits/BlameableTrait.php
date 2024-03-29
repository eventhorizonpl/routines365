<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait BlameableTrait
{
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Uuid(groups: ['system'])]
    #[ORM\Column(type: Types::GUID)]
    protected ?string $createdBy = null;

    #[Assert\Uuid(groups: ['system'])]
    #[ORM\Column(nullable: true, type: Types::GUID)]
    protected ?string $deletedBy = null;

    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Uuid(groups: ['system'])]
    #[ORM\Column(type: Types::GUID)]
    protected ?string $updatedBy = null;

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }

    public function setCreatedBy(string $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getDeletedBy(): ?string
    {
        return $this->deletedBy;
    }

    public function setDeletedBy(?string $deletedBy): self
    {
        $this->deletedBy = $deletedBy;

        return $this;
    }

    public function getUpdatedBy(): ?string
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(string $updatedBy): self
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }
}
