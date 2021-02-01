<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ReportRepository;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ReportRepository::class)
 * @ORM\Table(indexes={@ORM\Index(name="status_idx", columns={"status"}), @ORM\Index(name="type_idx", columns={"type"})})
 */
class Report
{
    use Traits\IdTrait;
    use Traits\UuidTrait;
    use Traits\TimestampableTrait;

    public const DATA_KEY_CREATE_SENT_REMINDER = 'create_sent_reminder';
    public const DATA_KEY_REMINDER = 'reminder';
    public const DATA_KEY_REMINDER_MESSAGE = 'reminder_message';
    public const DATA_KEY_SENT_REMINDER = 'sent_reminder';
    public const STATUS_FINISHED = 'finished';
    public const STATUS_INITIAL = 'initial';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const TYPE_POST_REMIND_MESSAGES = 'post_remind_messages';

    /**
     * @Assert\Type("array", groups={"system"})
     * @ORM\Column(type="json")
     */
    private array $data;

    /**
     * @Assert\Choice(callback="getStatusValidationChoices", groups={"system"})
     * @Assert\Length(max = 12, groups={"system"})
     * @Assert\NotBlank(groups={"system"})
     * @Assert\Type("string", groups={"system"})
     * @ORM\Column(length=12, type="string")
     */
    private string $status;

    /**
     * @Assert\Choice(callback="getTypeValidationChoices", groups={"system"})
     * @Assert\Length(max = 24, groups={"system"})
     * @Assert\NotBlank(groups={"system"})
     * @Assert\Type("string", groups={"system"})
     * @ORM\Column(length=24, type="string")
     */
    private string $type;

    public function __construct()
    {
        $this->data = [];
        $this->status = self::STATUS_INITIAL;
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
            self::STATUS_FINISHED => self::STATUS_FINISHED,
            self::STATUS_INITIAL => self::STATUS_INITIAL,
            self::STATUS_IN_PROGRESS => self::STATUS_IN_PROGRESS,
        ];
    }

    public static function getStatusValidationChoices(): array
    {
        return array_keys(self::getStatusFormChoices());
    }

    public function setStatus(string $status): self
    {
        if (!(in_array($status, self::getStatusValidationChoices()))) {
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
            self::TYPE_POST_REMIND_MESSAGES => self::TYPE_POST_REMIND_MESSAGES,
        ];
    }

    public static function getTypeValidationChoices(): array
    {
        return array_keys(self::getTypeFormChoices());
    }

    public function setType(string $type): self
    {
        if (!(in_array($type, self::getTypeValidationChoices()))) {
            throw new InvalidArgumentException('Invalid type');
        }

        $this->type = $type;

        return $this;
    }
}
