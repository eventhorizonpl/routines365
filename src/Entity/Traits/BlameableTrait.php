<?php

namespace App\Entity\Traits;

use Symfony\Component\Validator\Constraints as Assert;

trait BlameableTrait
{
    /**
     * @Assert\NotBlank(groups={"system"})
     * @Assert\Uuid
     * @ORM\Column(type="guid")
     */
    protected $createdBy;

    /**
     * @Assert\Uuid
     * @ORM\Column(type="guid", nullable=true)
     */
    protected $deletedBy;

    /**
     * @Assert\NotBlank(groups={"system"})
     * @Assert\Uuid
     * @ORM\Column(type="guid")
     */
    protected $updatedBy;

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
