<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

trait UuidTrait
{
    /**
     * @Groups({"gdpr", "list", "show"})
     * @ORM\Column(type="guid", unique=true)
     */
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Uuid(groups: ['Default', 'system'])]
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
