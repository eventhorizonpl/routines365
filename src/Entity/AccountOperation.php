<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\AccountOperationTypeEnum;
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
    use Traits\BlameableTrait;
    use Traits\IdTrait;
    use Traits\TimestampableTrait;
    use Traits\UuidTrait;

    /**
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="accountOperations", targetEntity=Account::class)
     */
    #[Assert\Valid(groups: ['system'])]
    private Account $account;

    /**
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     * @ORM\OneToOne(fetch="EXTRA_LAZY", inversedBy="accountOperation", targetEntity=ReminderMessage::class)
     */
    #[Assert\Valid(groups: ['system'])]
    private ?ReminderMessage $reminderMessage;

    /**
     * @ORM\Column(type="string")
     */
    #[Assert\Length(groups: ['system'], max: 255)]
    #[Assert\Type('string', groups: ['system'])]
    private string $description;

    /**
     * @ORM\Column(type="integer")
     */
    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\LessThanOrEqual(1024, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    private int $notifications;

    /**
     * @ORM\Column(type="integer")
     */
    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\LessThanOrEqual(1024, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    private int $smsNotifications;

    /**
     * @ORM\Column(length=8, type="string")
     */
    #[Assert\Choice(callback: 'getTypeValidationChoices', groups: ['system'])]
    #[Assert\Length(groups: ['system'], max: 8)]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('string', groups: ['system'])]
    private string $type;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public static function getTypeFormChoices(): array
    {
        return [
            AccountOperationTypeEnum::DEPOSIT => AccountOperationTypeEnum::DEPOSIT,
            AccountOperationTypeEnum::WITHDRAW => AccountOperationTypeEnum::WITHDRAW,
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
