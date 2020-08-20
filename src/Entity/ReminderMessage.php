<?php

namespace App\Entity;

use App\Repository\ReminderMessageRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ReminderMessageRepository::class)
 * @ORM\Table(indexes={@ORM\Index(name="type_idx", columns={"type"})})
 */
class ReminderMessage
{
    use Traits\IdTrait;
    use Traits\UuidTrait;
    use Traits\TimestampableTrait;

    public const TYPE_EMAIL = 'email';
    public const TYPE_SMS = 'sms';

    /**
     * @Assert\Valid
     * @ORM\OneToOne(fetch="EXTRA_LAZY", mappedBy="reminderMessage", targetEntity=AccountOperation::class)
     */
    private AccountOperation $accountOperation;

    /**
     * @Assert\Valid
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="reminderMessages", targetEntity=Reminder::class)
     */
    private Reminder $reminder;

    /**
     * @Assert\Length(
     *   max = 512
     * )
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @ORM\Column(length=512, type="string")
     */
    private string $content;

    /**
     * @Assert\Type("DateTimeImmutable")
     * @ORM\Column(nullable=true, type="datetimetz_immutable")
     */
    private ?DateTimeImmutable $postDate;

    /**
     * @Assert\Choice(callback="getTypeValidationChoices")
     * @Assert\Length(
     *   max = 10
     * )
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @ORM\Column(length=10, type="string")
     */
    private string $type;

    public function __construct()
    {
        $this->content = '';
        $this->type = self::TYPE_EMAIL;
    }

    public function __toString(): string
    {
        return $this->getUuid();
    }

    public function getAccountOperation(): AccountOperation
    {
        return $this->accountOperation;
    }

    public function setAccountOperation(AccountOperation $accountOperation): self
    {
        $this->accountOperation = $accountOperation;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPostDate(): ?DateTimeImmutable
    {
        return $this->postDate;
    }

    public function setPostDate(DateTimeImmutable $postDate): self
    {
        $this->postDate = $postDate;

        return $this;
    }

    public function getReminder(): ?Reminder
    {
        return $this->reminder;
    }

    public function setReminder(Reminder $reminder): self
    {
        $this->reminder = $reminder;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public static function getTypeFormChoices(): array
    {
        return [
            self::TYPE_EMAIL => self::TYPE_EMAIL,
            self::TYPE_SMS => self::TYPE_SMS,
        ];
    }

    public function getTypeValidationChoices(): array
    {
        return array_keys(self::getTypeFormChoices());
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
