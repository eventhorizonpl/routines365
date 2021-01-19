<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AccountOperationRepository;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AccountOperationRepository::class)
 * @ORM\Table(indexes={@ORM\Index(name="type_idx", columns={"type"})})
 */
class AccountOperation
{
    use Traits\IdTrait;
    use Traits\UuidTrait;
    use Traits\BlameableTrait;
    use Traits\TimestampableTrait;

    public const TYPE_DEPOSIT = 'deposit';
    public const TYPE_WITHDRAW = 'withdraw';

    /**
     * @Assert\Valid(groups={"system"})
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="accountOperations", targetEntity=Account::class)
     */
    private Account $account;

    /**
     * @Assert\Valid(groups={"system"})
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     * @ORM\OneToOne(fetch="EXTRA_LAZY", inversedBy="accountOperation", targetEntity=ReminderMessage::class)
     */
    private ?ReminderMessage $reminderMessage;

    /**
     * @Assert\GreaterThanOrEqual(0, groups={"system"})
     * @Assert\LessThanOrEqual(1024, groups={"system"})
     * @Assert\NotBlank(groups={"system"})
     * @Assert\Type("int", groups={"system"})
     * @ORM\Column(type="integer")
     */
    private int $browserNotifications;

    /**
     * @Assert\Length(max = 255, groups={"system"})
     * @Assert\Type("string", groups={"system"})
     * @ORM\Column(type="string")
     */
    private string $description;

    /**
     * @Assert\GreaterThanOrEqual(0, groups={"system"})
     * @Assert\LessThanOrEqual(1024, groups={"system"})
     * @Assert\NotBlank(groups={"system"})
     * @Assert\Type("int", groups={"system"})
     * @ORM\Column(type="integer")
     */
    private int $emailNotifications;

    /**
     * @Assert\GreaterThanOrEqual(0, groups={"system"})
     * @Assert\LessThanOrEqual(1024, groups={"system"})
     * @Assert\NotBlank(groups={"system"})
     * @Assert\Type("int", groups={"system"})
     * @ORM\Column(type="integer")
     */
    private int $smsNotifications;

    /**
     * @Assert\Choice(callback="getTypeValidationChoices", groups={"system"})
     * @Assert\Length(max = 8, groups={"system"})
     * @Assert\NotBlank(groups={"system"})
     * @Assert\Type("string", groups={"system"})
     * @ORM\Column(length=8, type="string")
     */
    private string $type;

    public function __construct()
    {
        $this->browserNotifications = 0;
        $this->description = '';
        $this->emailNotifications = 0;
        $this->reminderMessage = null;
        $this->smsNotifications = 0;
    }

    public function __toString(): string
    {
        return $this->getUuid();
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(Account $account): self
    {
        $this->account = $account;

        return $this;
    }

    public function getBrowserNotifications(): int
    {
        return $this->browserNotifications;
    }

    public function setBrowserNotifications(int $browserNotifications): self
    {
        $this->browserNotifications = abs($browserNotifications);

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getEmailNotifications(): int
    {
        return $this->emailNotifications;
    }

    public function setEmailNotifications(int $emailNotifications): self
    {
        $this->emailNotifications = abs($emailNotifications);

        return $this;
    }

    public function getReminderMessage(): ?ReminderMessage
    {
        return $this->reminderMessage;
    }

    public function setReminderMessage(ReminderMessage $reminderMessage): self
    {
        $this->reminderMessage = $reminderMessage;

        return $this;
    }

    public function getSmsNotifications(): int
    {
        return $this->smsNotifications;
    }

    public function setSmsNotifications(int $smsNotifications): self
    {
        $this->smsNotifications = abs($smsNotifications);

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public static function getTypeFormChoices(): array
    {
        return [
            self::TYPE_DEPOSIT => self::TYPE_DEPOSIT,
            self::TYPE_WITHDRAW => self::TYPE_WITHDRAW,
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
