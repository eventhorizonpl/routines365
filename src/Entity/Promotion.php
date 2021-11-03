<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\PromotionTypeEnum;
use App\Repository\PromotionRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\{ArrayCollection, Collection};
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PromotionRepository::class)]
#[ORM\Index(name: 'type_idx', columns: ['type'])]
#[UniqueEntity(fields: ['code'], groups: ['form', 'system'])]
class Promotion
{
    use Traits\BlameableTrait;
    use Traits\IdTrait;
    use Traits\IsEnabledTrait;
    use Traits\TimestampableTrait;
    use Traits\UuidTrait;

    #[ORM\ManyToMany(fetch: 'EXTRA_LAZY', mappedBy: 'promotions', targetEntity: User::class)]
    private Collection $users;

    #[Assert\Length(groups: ['form', 'system'], max: 64)]
    #[Assert\NotBlank(groups: ['form', 'system'])]
    #[Assert\Type('string', groups: ['form', 'system'])]
    #[ORM\Column(length: 64, type: Types::STRING, unique: true)]
    private ?string $code;

    #[Assert\Length(groups: ['form', 'system'], max: 255)]
    #[Assert\Type('string', groups: ['form', 'system'])]
    #[ORM\Column(nullable: true, type: Types::STRING)]
    private ?string $description;

    #[Assert\Type('DateTimeImmutable', groups: ['form', 'system'])]
    #[ORM\Column(nullable: true, type: Types::DATETIMETZ_IMMUTABLE)]
    private ?DateTimeImmutable $expiresAt;

    #[Assert\Length(groups: ['form', 'system'], max: 128)]
    #[Assert\NotBlank(groups: ['form', 'system'])]
    #[Assert\Type('string', groups: ['form', 'system'])]
    #[ORM\Column(length: 128, type: Types::STRING)]
    private ?string $name;

    #[Assert\GreaterThanOrEqual(0, groups: ['form', 'system'])]
    #[Assert\LessThanOrEqual(10, groups: ['form', 'system'])]
    #[Assert\NotBlank(groups: ['form', 'system'])]
    #[Assert\Type('int', groups: ['form', 'system'])]
    #[ORM\Column(type: Types::INTEGER)]
    private int $notifications;

    #[Assert\GreaterThanOrEqual(0, groups: ['form', 'system'])]
    #[Assert\LessThanOrEqual(10, groups: ['form', 'system'])]
    #[Assert\NotBlank(groups: ['form', 'system'])]
    #[Assert\Type('int', groups: ['form', 'system'])]
    #[ORM\Column(type: Types::INTEGER)]
    private int $smsNotifications;

    #[Assert\Choice(callback: 'getTypeValidationChoices', groups: ['form', 'system'])]
    #[Assert\Length(groups: ['form', 'system'], max: 24)]
    #[Assert\NotBlank(groups: ['form', 'system'])]
    #[Assert\Type('string', groups: ['form', 'system'])]
    #[ORM\Column(length: 24, type: Types::STRING)]
    private string $type;

    public function __construct()
    {
        $this->code = '';
        $this->description = null;
        $this->expiresAt = null;
        $this->isEnabled = true;
        $this->name = '';
        $this->notifications = 0;
        $this->smsNotifications = 0;
        $this->users = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getCode();
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = (null !== $code) ? strtoupper(preg_replace('/[^a-z0-9]/i', '', $code)) : $code;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getExpiresAt(): ?DateTimeImmutable
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(?DateTimeImmutable $expiresAt): self
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getNotifications(): ?int
    {
        return $this->notifications;
    }

    public function setNotifications(int $notifications): self
    {
        $this->notifications = $notifications;

        return $this;
    }

    public function getSmsNotifications(): ?int
    {
        return $this->smsNotifications;
    }

    public function setSmsNotifications(int $smsNotifications): self
    {
        $this->smsNotifications = $smsNotifications;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public static function getTypeFormChoices(): array
    {
        return [
            PromotionTypeEnum::EXISTING_ACCOUNT => PromotionTypeEnum::EXISTING_ACCOUNT,
            PromotionTypeEnum::NEW_ACCOUNT => PromotionTypeEnum::NEW_ACCOUNT,
            PromotionTypeEnum::SYSTEM => PromotionTypeEnum::SYSTEM,
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

    public function addUser(User $user): self
    {
        if (false === $this->users->contains($user)) {
            $this->users->add($user);
        }

        return $this;
    }

    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function removeUser(User $user): self
    {
        if (true === $this->users->contains($user)) {
            $this->users->removeElement($user);
        }

        return $this;
    }
}
