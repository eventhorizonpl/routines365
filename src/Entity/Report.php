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
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type(ReportStatusEnum::class, groups: ['system'])]
    #[ORM\Column(enumType: ReportStatusEnum::class, length: 12, type: Types::STRING)]
    private ReportStatusEnum $status;

    #[Assert\Choice(callback: 'getTypeValidationChoices', groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type(ReportTypeEnum::class, groups: ['system'])]
    #[ORM\Column(enumType: ReportTypeEnum::class, length: 24, type: Types::STRING)]
    private ReportTypeEnum $type;

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

    public function getStatus(): ?ReportStatusEnum
    {
        return $this->status;
    }

    public static function getStatusFormChoices(): array
    {
        return [
            ReportStatusEnum::FINISHED->value => ReportStatusEnum::FINISHED->value,
            ReportStatusEnum::INITIAL->value => ReportStatusEnum::INITIAL->value,
            ReportStatusEnum::IN_PROGRESS->value => ReportStatusEnum::IN_PROGRESS->value,
        ];
    }

    public static function getStatusValidationChoices(): array
    {
        return [
            ReportStatusEnum::FINISHED,
            ReportStatusEnum::INITIAL,
            ReportStatusEnum::IN_PROGRESS,
        ];
    }

    public function setStatus(ReportStatusEnum $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getType(): ?ReportTypeEnum
    {
        return $this->type;
    }

    public static function getTypeFormChoices(): array
    {
        return [
            ReportTypeEnum::POST_REMIND_MESSAGES->value => ReportTypeEnum::POST_REMIND_MESSAGES->value,
        ];
    }

    public static function getTypeValidationChoices(): array
    {
        return [
            ReportTypeEnum::POST_REMIND_MESSAGES,
        ];
    }

    public function setType(ReportTypeEnum $type): self
    {
        $this->type = $type;

        return $this;
    }
}
