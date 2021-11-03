<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\SavedEmailTypeEnum;
use App\Repository\SavedEmailRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SavedEmailRepository::class)]
#[ORM\Index(name: 'email_idx', columns: ['email'])]
#[ORM\Index(name: 'type_idx', columns: ['type'])]
class SavedEmail
{
    use Traits\BlameableTrait;
    use Traits\IdTrait;
    use Traits\TimestampableTrait;
    use Traits\UuidTrait;

    #[Assert\Valid(groups: ['system'])]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[ORM\ManyToOne(fetch: 'EXTRA_LAZY', inversedBy: 'savedEmails', targetEntity: User::class)]
    private User $user;

    #[Assert\Email(groups: ['system'])]
    #[Assert\Length(groups: ['system'], max: 180)]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('string', groups: ['system'])]
    #[Groups(['gdpr'])]
    #[ORM\Column(length: 180, type: Types::STRING)]
    private string $email;

    #[Assert\Choice(callback: 'getTypeValidationChoices', groups: ['system'])]
    #[Assert\Length(groups: ['system'], max: 16)]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('string', groups: ['system'])]
    #[Groups(['gdpr'])]
    #[ORM\Column(length: 16, type: Types::STRING)]
    private string $type;

    public function __construct()
    {
        $this->email = '';
        $this->type = SavedEmailTypeEnum::INVITATION;
    }

    public function __toString(): string
    {
        return $this->getUuid();
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public static function getTypeFormChoices(): array
    {
        return [
            SavedEmailTypeEnum::INVITATION => SavedEmailTypeEnum::INVITATION,
            SavedEmailTypeEnum::MOTIVATIONAL => SavedEmailTypeEnum::MOTIVATIONAL,
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
