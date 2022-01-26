<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\AccountOperationTypeEnum;
use App\Repository\AccountOperationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AccountOperationRepository::class)]
#[ORM\Index(name: 'type_idx', columns: ['type'])]
class AccountOperation
{
    use Traits\BlameableTrait;
    use Traits\IdTrait;
    use Traits\TimestampableTrait;
    use Traits\UuidTrait;

    #[Assert\Valid(groups: ['system'])]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[ORM\ManyToOne(fetch: 'EXTRA_LAZY', inversedBy: 'accountOperations', targetEntity: Account::class)]
    private Account $account;

    #[Assert\Valid(groups: ['system'])]
    #[ORM\JoinColumn(nullable: true, onDelete: 'CASCADE')]
    #[ORM\OneToOne(fetch: 'EXTRA_LAZY', inversedBy: 'accountOperation', targetEntity: ReminderMessage::class)]
    private ?ReminderMessage $reminderMessage;

    #[Assert\Length(groups: ['system'], max: 255)]
    #[Assert\Type('string', groups: ['system'])]
    #[ORM\Column(type: Types::STRING)]
    private string $description;

    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\LessThanOrEqual(1024, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    #[ORM\Column(type: Types::INTEGER)]
    private int $notifications;

    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\LessThanOrEqual(1024, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    #[ORM\Column(type: Types::INTEGER)]
    private int $smsNotifications;

    #[Assert\Choice(callback: 'getTypeValidationChoices', groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type(AccountOperationTypeEnum::class, groups: ['system'])]
    #[ORM\Column(enumType: AccountOperationTypeEnum::class, length: 8, type: Types::STRING)]
    private AccountOperationTypeEnum $type;

    public function __construct()
    {
        $this->description = '';
        $this->notifications = 0;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNotifications(): int
    {
        return $this->notifications;
    }

    public function setNotifications(int $notifications): self
    {
        $this->notifications = abs($notifications);

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

    public function getType(): ?AccountOperationTypeEnum
    {
        return $this->type;
    }

    public static function getTypeFormChoices(): array
    {
        return [
            AccountOperationTypeEnum::DEPOSIT->value => AccountOperationTypeEnum::DEPOSIT->value,
            AccountOperationTypeEnum::WITHDRAW->value => AccountOperationTypeEnum::WITHDRAW->value,
        ];
    }

    public static function getTypeValidationChoices(): array
    {
        return [
            AccountOperationTypeEnum::DEPOSIT,
            AccountOperationTypeEnum::WITHDRAW,
        ];
    }

    public function setType(AccountOperationTypeEnum $type): self
    {
        $this->type = $type;

        return $this;
    }
}
