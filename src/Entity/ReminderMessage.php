<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ReminderMessageRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ReminderMessageRepository::class)
 * @ORM\Table(indexes={@ORM\Index(name="type_idx", columns={"type"})})
 */
class ReminderMessage
{
    use Traits\IdTrait;
    use Traits\TimestampableTrait;
    use Traits\UuidTrait;

    public const THIRD_PARTY_SYSTEM_TYPE_AMAZON_SES = 'amazon_ses';
    public const THIRD_PARTY_SYSTEM_TYPE_AMAZON_SNS = 'amazon_sns';
    public const TYPE_BROWSER = 'browser';
    public const TYPE_EMAIL = 'email';
    public const TYPE_SMS = 'sms';

    /**
     * @ORM\OneToOne(fetch="EXTRA_LAZY", mappedBy="reminderMessage", targetEntity=AccountOperation::class)
     */
    #[Assert\Valid(groups: ['system'])]
    private ?AccountOperation $accountOperation = null;

    /**
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="reminderMessages", targetEntity=Reminder::class)
     */
    #[Assert\Valid(groups: ['system'])]
    private Reminder $reminder;

    /**
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="reminderMessages", targetEntity=SentReminder::class)
     */
    #[Assert\Valid(groups: ['system'])]
    private SentReminder $sentReminder;

    /**
     * @ORM\Column(length=512, type="string")
     */
    #[Assert\Length(groups: ['system'], max: 512)]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('string', groups: ['system'])]
    private string $content;

    /**
     * @ORM\Column(type="boolean")
     */
    #[Assert\NotNull(groups: ['system'])]
    #[Assert\Type('bool', groups: ['system'])]
    private bool $isReadFromBrowser;

    /**
     * @ORM\Column(nullable=true, type="datetimetz_immutable")
     */
    #[Assert\Type('DateTimeImmutable', groups: ['system'])]
    private ?DateTimeImmutable $postDate;

    /**
     * @ORM\Column(nullable=true, type="string")
     */
    #[Assert\Length(groups: ['system'], max: 255)]
    #[Assert\Type('string', groups: ['system'])]
    private ?string $thirdPartySystemResponse;

    /**
     * @ORM\Column(length=10, nullable=true, type="string")
     */
    #[Assert\Choice(callback: 'getThirdPartySystemTypeValidationChoices', groups: ['system'])]
    #[Assert\Length(groups: ['system'], max: 10)]
    #[Assert\Type('string', groups: ['system'])]
    private ?string $thirdPartySystemType;

    /**
     * @ORM\Column(length=10, type="string")
     */
    #[Assert\Choice(callback: 'getTypeValidationChoices', groups: ['system'])]
    #[Assert\Length(groups: ['system'], max: 10)]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('string', groups: ['system'])]
    private string $type;

    public function __construct()
    {
        $this->content = '';
        $this->isReadFromBrowser = false;
        $this->thirdPartySystemResponse = null;
        $this->thirdPartySystemType = null;
        $this->type = self::TYPE_EMAIL;
    }

    public function __toString(): string
    {
        return $this->getUuid();
    }

    public function getAccountOperation(): ?AccountOperation
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

    public function getIsReadFromBrowser(): ?bool
    {
        return $this->isReadFromBrowser;
    }

    public function setIsReadFromBrowser(bool $isReadFromBrowser): self
    {
        $this->isReadFromBrowser = $isReadFromBrowser;

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

    public function getSentReminder(): ?SentReminder
    {
        return $this->sentReminder;
    }

    public function setSentReminder(SentReminder $sentReminder): self
    {
        $this->sentReminder = $sentReminder;

        return $this;
    }

    public function getThirdPartySystemResponse(): ?string
    {
        return $this->thirdPartySystemResponse;
    }

    public function setThirdPartySystemResponse(?string $thirdPartySystemResponse): self
    {
        $this->thirdPartySystemResponse = $thirdPartySystemResponse;

        return $this;
    }

    public function getThirdPartySystemType(): ?string
    {
        return $this->thirdPartySystemType;
    }

    public static function getThirdPartySystemTypeFormChoices(): array
    {
        return [
            self::THIRD_PARTY_SYSTEM_TYPE_AMAZON_SES => self::THIRD_PARTY_SYSTEM_TYPE_AMAZON_SES,
            self::THIRD_PARTY_SYSTEM_TYPE_AMAZON_SNS => self::THIRD_PARTY_SYSTEM_TYPE_AMAZON_SNS,
        ];
    }

    public static function getThirdPartySystemTypeValidationChoices(): array
    {
        return array_keys(self::getThirdPartySystemTypeFormChoices());
    }

    public function setThirdPartySystemType(?string $thirdPartySystemType): self
    {
        if (!(\in_array($thirdPartySystemType, self::getThirdPartySystemTypeValidationChoices(), true))) {
            throw new InvalidArgumentException('Invalid third party system type');
        }

        $this->thirdPartySystemType = $thirdPartySystemType;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public static function getTypeFormChoices(): array
    {
        return [
            self::TYPE_BROWSER => self::TYPE_BROWSER,
            self::TYPE_EMAIL => self::TYPE_EMAIL,
            self::TYPE_SMS => self::TYPE_SMS,
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
