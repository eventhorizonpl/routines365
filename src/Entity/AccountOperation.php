<?php

namespace App\Entity;

use App\Repository\AccountOperationRepository;
use Doctrine\ORM\Mapping as ORM;
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
     * @Assert\Valid
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="accountOperations", targetEntity=Account::class)
     */
    private Account $account;

    /**
     * @Assert\Valid
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     * @ORM\OneToOne(fetch="EXTRA_LAZY", inversedBy="accountOperation", targetEntity=ReminderMessage::class)
     */
    private ?ReminderMessage $reminderMessage;

    /**
     * @Assert\Length(
     *   max = 255
     * )
     * @Assert\Type("string")
     * @ORM\Column(type="string")
     */
    private string $description;

    /**
     * @Assert\GreaterThanOrEqual(0)
     * @Assert\LessThanOrEqual(1024)
     * @Assert\NotBlank
     * @Assert\Type("int")
     * @ORM\Column(type="integer")
     */
    private int $emailNotifications;

    /**
     * @Assert\GreaterThanOrEqual(0)
     * @Assert\LessThanOrEqual(1024)
     * @Assert\NotBlank
     * @Assert\Type("int")
     * @ORM\Column(type="integer")
     */
    private int $smsNotifications;

    /**
     * @Assert\Choice(callback="getTypeValidationChoices")
     * @Assert\Length(
     *   max = 8
     * )
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @ORM\Column(length=8, type="string")
     */
    private string $type;

    public function __construct()
    {
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
        $this->type = $type;

        return $this;
    }
}
