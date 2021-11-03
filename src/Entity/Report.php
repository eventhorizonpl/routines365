<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\{ReportStatusEnum, ReportTypeEnum};
use App\Repository\ReportRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReportRepository::class)]
#[ORM\Index(name: 'status_idx', columns: ['status'])]
#[ORM\Index(name: 'type_idx', columns: ['type'])]
class Report
{
    use Traits\IdTrait;
    use Traits\TimestampableTrait;
    use Traits\UuidTrait;

    #[Assert\Type('array', groups: ['system'])]
    #[ORM\Column(type: Types::JSON)]
    private array $data;

    #[Assert\Choice(callback: 'getStatusValidationChoices', groups: ['system'])]
    #[Assert\Length(groups: ['system'], max: 12)]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('string', groups: ['system'])]
    #[ORM\Column(length: 12, type: Types::STRING)]
    private string $status;

    #[Assert\Choice(callback: 'getTypeValidationChoices', groups: ['system'])]
    #[Assert\Length(groups: ['system'], max: 24)]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('string', groups: ['system'])]
    #[ORM\Column(length: 24, type: Types::STRING)]
    private string $type;

    public function __construct()
    {
        $this->data = [];
        $this->status = ReportStatusEnum::INITIAL;
    }

    public function __toString(): string
    {
        return $this->getUuid();
    }

    public function addData(array $data): self
    {
        $this->data[] = $data;

        return $this;
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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public static function getStatusFormChoices(): array
    {
        return [
            ReportStatusEnum::FINISHED => ReportStatusEnum::FINISHED,
            ReportStatusEnum::INITIAL => ReportStatusEnum::INITIAL,
            ReportStatusEnum::IN_PROGRESS => ReportStatusEnum::IN_PROGRESS,
        ];
    }

    public static function getStatusValidationChoices(): array
    {
        return array_keys(self::getStatusFormChoices());
    }

    public function setStatus(string $status): self
    {
        if (!(\in_array($status, self::getStatusValidationChoices(), true))) {
            throw new InvalidArgumentException('Invalid status');
        }

        $this->status = $status;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public static function getTypeFormChoices(): array
    {
        return [
            ReportTypeEnum::POST_REMIND_MESSAGES => ReportTypeEnum::POST_REMIND_MESSAGES,
        ];
    }

    public static function getTypeValidationChoices(): array
    {
        return array_keys(self::getTypeFormChoices());
    }

    public function setType(string $type): self
    {
        if (!(\in_array($type, self::getTypeValidationChoices(), true))) {
            throw new InvalidArgumentException('Invalid type');
        }

        $this->type = $type;

        return $this;
    }
}
