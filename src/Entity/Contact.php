<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\{ContactStatusEnum, ContactTypeEnum};
use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 * @ORM\Table(indexes={@ORM\Index(name="type_idx", columns={"type"}), @ORM\Index(name="status_idx", columns={"status"})})
 */
class Contact
{
    use Traits\BlameableTrait;
    use Traits\IdTrait;
    use Traits\TimestampableTrait;
    use Traits\UuidTrait;

    /**
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="contacts", targetEntity=User::class)
     */
    #[Assert\Valid(groups: ['system'])]
    private User $user;

    /**
     * @ORM\Column(length=2048, nullable=true, type="string")
     */
    #[Assert\Length(groups: ['form', 'system'], max: 2048)]
    #[Assert\Type('string', groups: ['form', 'system'])]
    private ?string $comment;

    /**
     * @ORM\Column(length=2048, type="string")
     */
    #[Assert\Length(groups: ['form', 'system'], max: 2048)]
    #[Assert\NotBlank(groups: ['form', 'system'])]
    #[Assert\Type('string', groups: ['form', 'system'])]
    #[Groups(['gdpr'])]
    private ?string $content;

    /**
     * @ORM\Column(length=8, type="string")
     */
    #[Assert\Choice(callback: 'getStatusValidationChoices', groups: ['system'])]
    #[Assert\Length(groups: ['system'], max: 8)]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('string', groups: ['system'])]
    private string $status;

    /**
     * @ORM\Column(type="string")
     */
    #[Assert\Length(groups: ['form', 'system'], max: 255)]
    #[Assert\NotBlank(groups: ['form', 'system'])]
    #[Assert\Type('string', groups: ['form', 'system'])]
    #[Groups(['gdpr'])]
    private ?string $title;

    /**
     * @ORM\Column(length=16, type="string")
     */
    #[Assert\Choice(callback: 'getTypeValidationChoices', groups: ['form', 'system'])]
    #[Assert\Length(groups: ['form', 'system'], max: 16)]
    #[Assert\NotBlank(groups: ['form', 'system'])]
    #[Assert\Type('string', groups: ['form', 'system'])]
    #[Groups(['gdpr'])]
    private string $type;

    public function __construct()
    {
        $this->comment = '';
        $this->content = '';
        $this->status = ContactStatusEnum::OPEN;
        $this->title = '';
        $this->type = ContactTypeEnum::QUESTION;
    }

    public function __toString(): string
    {
        return $this->getUuid();
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment = null): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public static function getStatusFormChoices(): array
    {
        return [
            ContactStatusEnum::CLOSED => ContactStatusEnum::CLOSED,
            ContactStatusEnum::ON_HOLD => ContactStatusEnum::ON_HOLD,
            ContactStatusEnum::OPEN => ContactStatusEnum::OPEN,
            ContactStatusEnum::PENDING => ContactStatusEnum::PENDING,
            ContactStatusEnum::SOLVED => ContactStatusEnum::SOLVED,
            ContactStatusEnum::SPAM => ContactStatusEnum::SPAM,
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public static function getTypeFormChoices(): array
    {
        return [
            ContactTypeEnum::FEATURE_IDEA => ContactTypeEnum::FEATURE_IDEA,
            ContactTypeEnum::QUESTION => ContactTypeEnum::QUESTION,
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
