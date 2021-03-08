<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use Symfony\Component\Validator\Constraints as Assert;

trait BlameableTrait
{
    /**
     * @ORM\Column(type="guid")
     */
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Uuid(groups: ['system'])]
    protected ?string $createdBy = null;

    /**
     * @ORM\Column(type="guid", nullable=true)
     */
    #[Assert\Uuid(groups: ['system'])]
    protected ?string $deletedBy = null;

    /**
     * @ORM\Column(type="guid")
     */
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Uuid(groups: ['system'])]
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
