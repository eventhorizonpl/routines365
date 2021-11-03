<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\RetentionRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RetentionRepository::class)]
class Retention
{
    use Traits\IdTrait;
    use Traits\TimestampableTrait;
    use Traits\UuidTrait;

    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('array', groups: ['system'])]
    #[ORM\Column(type: Types::JSON)]
    private array $data;

    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('DateTimeImmutable', groups: ['system'])]
    #[ORM\Column(type: Types::DATETIMETZ_IMMUTABLE)]
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
