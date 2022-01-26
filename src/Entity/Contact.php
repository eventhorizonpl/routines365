<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\{ContactStatusEnum, ContactTypeEnum};
use App\Repository\ContactRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
#[ORM\Index(name: 'type_idx', columns: ['type'])]
#[ORM\Index(name: 'status_idx', columns: ['status'])]
class Contact
{
    use Traits\BlameableTrait;
    use Traits\IdTrait;
    use Traits\TimestampableTrait;
    use Traits\UuidTrait;

    #[Assert\Valid(groups: ['system'])]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[ORM\ManyToOne(fetch: 'EXTRA_LAZY', inversedBy: 'contacts', targetEntity: User::class)]
    private User $user;

    #[Assert\Length(groups: ['form', 'system'], max: 2048)]
    #[Assert\Type('string', groups: ['form', 'system'])]
    #[ORM\Column(length: 2048, nullable: true, type: Types::STRING)]
    private ?string $comment;

    #[Assert\Length(groups: ['form', 'system'], max: 2048)]
    #[Assert\NotBlank(groups: ['form', 'system'])]
    #[Assert\Type('string', groups: ['form', 'system'])]
    #[Groups(['gdpr'])]
    #[ORM\Column(length: 2048, type: Types::STRING)]
    private ?string $content;

    #[Assert\Choice(callback: 'getStatusValidationChoices', groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type(ContactStatusEnum::class, groups: ['system'])]
    #[ORM\Column(enumType: ContactStatusEnum::class, length: 8, type: Types::STRING)]
    private ContactStatusEnum $status;

    #[Assert\Length(groups: ['form', 'system'], max: 255)]
    #[Assert\NotBlank(groups: ['form', 'system'])]
    #[Assert\Type('string', groups: ['form', 'system'])]
    #[Groups(['gdpr'])]
    #[ORM\Column(type: Types::STRING)]
    private ?string $title;

    #[Assert\Choice(callback: 'getTypeValidationChoices', groups: ['form', 'system'])]
    #[Assert\NotBlank(groups: ['form', 'system'])]
    #[Assert\Type(ContactTypeEnum::class, groups: ['form', 'system'])]
    #[Groups(['gdpr'])]
    #[ORM\Column(enumType: ContactTypeEnum::class, length: 16, type: Types::STRING)]
    private ContactTypeEnum $type;

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

    public function getStatus(): ?ContactStatusEnum
    {
        return $this->status;
    }

    public static function getStatusFormChoices(): array
    {
        return [
            ContactStatusEnum::CLOSED->value => ContactStatusEnum::CLOSED->value,
            ContactStatusEnum::ON_HOLD->value => ContactStatusEnum::ON_HOLD->value,
            ContactStatusEnum::OPEN->value => ContactStatusEnum::OPEN->value,
            ContactStatusEnum::PENDING->value => ContactStatusEnum::PENDING->value,
            ContactStatusEnum::SOLVED->value => ContactStatusEnum::SOLVED->value,
            ContactStatusEnum::SPAM->value => ContactStatusEnum::SPAM->value,
        ];
    }

    public static function getStatusValidationChoices(): array
    {
        return [
            ContactStatusEnum::CLOSED,
            ContactStatusEnum::ON_HOLD,
            ContactStatusEnum::OPEN,
            ContactStatusEnum::PENDING,
            ContactStatusEnum::SOLVED,
            ContactStatusEnum::SPAM,
        ];
    }

    public function setStatus(ContactStatusEnum $status): self
    {
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

    public function getType(): ?ContactTypeEnum
    {
        return $this->type;
    }

    public static function getTypeFormChoices(): array
    {
        return [
            ContactTypeEnum::FEATURE_IDEA->value => ContactTypeEnum::FEATURE_IDEA->value,
            ContactTypeEnum::QUESTION->value => ContactTypeEnum::QUESTION->value,
        ];
    }

    public static function getTypeValidationChoices(): array
    {
        return [
            ContactTypeEnum::FEATURE_IDEA,
            ContactTypeEnum::QUESTION,
        ];
    }

    public function setType(ContactTypeEnum $type): self
    {
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
