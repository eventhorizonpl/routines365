<?php

namespace App\Entity\Traits;

use Symfony\Component\Validator\Constraints as Assert;

trait UuidTrait
{
    /**
     * @Assert\NotBlank
     * @Assert\Uuid
     * @ORM\Column(type="guid", unique=true)
     */
    protected $uuid;

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
