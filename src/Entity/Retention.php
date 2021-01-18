<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\RetentionRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=RetentionRepository::class)
 */
class Retention
{
    use Traits\IdTrait;
    use Traits\UuidTrait;
    use Traits\TimestampableTrait;

    /**
     * @Assert\NotBlank(groups={"form", "system"})
     * @Assert\Type("array", groups={"form", "system"})
     * @ORM\Column(type="json")
     */
    private array $data;

    /**
     * @Assert\NotBlank(groups={"system"})
     * @Assert\Type("DateTimeImmutable", groups={"system"})
     * @ORM\Column(type="datetimetz_immutable")
     */
    private ?DateTimeImmutable $date;

    public function __toString(): string
    {
        return $this->getUuid();
    }

    public function getData(): ?array
    {
        return $this->data;
    }

    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getDate(): ?DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(DateTimeImmutable $date): self
    {
        $this->date = $date;

        return $this;
    }
}
