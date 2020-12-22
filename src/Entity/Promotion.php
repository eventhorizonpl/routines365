<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PromotionRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PromotionRepository::class)
 * @ORM\Table(indexes={@ORM\Index(name="type_idx", columns={"type"})})
 */
class Promotion
{
    use Traits\IdTrait;
    use Traits\UuidTrait;
    use Traits\IsEnabledTrait;
    use Traits\BlameableTrait;
    use Traits\TimestampableTrait;

    public const TYPE_EXISTING_ACCOUNT = 'existing_account';
    public const TYPE_NEW_ACCOUNT = 'new_account';
    public const TYPE_SYSTEM = 'system';

    /**
     * @ORM\ManyToMany(fetch="EXTRA_LAZY", mappedBy="promotions", targetEntity=User::class)
     */
    private Collection $users;

    /**
     * @Assert\Length(
     *   max = 64
     * )
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @ORM\Column(length=64, type="string", unique=true)
     */
    private string $code;

    /**
     * @Assert\Length(
     *   max = 255
     * )
     * @Assert\Type("string")
     * @ORM\Column(nullable=true, type="string")
     */
    private ?string $description;

    /**
     * @Assert\GreaterThanOrEqual(0)
     * @Assert\LessThanOrEqual(10)
     * @Assert\NotBlank
     * @Assert\Type("int")
     * @ORM\Column(type="integer")
     */
    private int $emailNotifications;

    /**
     * @Assert\Type("DateTimeImmutable")
     * @ORM\Column(nullable=true, type="datetimetz_immutable")
     */
    protected $expiresAt;

    /**
     * @Assert\Length(
     *   max = 128
     * )
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @ORM\Column(length=128, type="string")
     */
    private string $name;

    /**
     * @Assert\GreaterThanOrEqual(0)
     * @Assert\LessThanOrEqual(10)
     * @Assert\NotBlank
     * @Assert\Type("int")
     * @ORM\Column(type="integer")
     */
    private int $smsNotifications;

    /**
     * @Assert\Choice(callback="getTypeValidationChoices")
     * @Assert\Length(
     *   max = 24
     * )
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @ORM\Column(length=24, type="string")
     */
    private string $type;

    public function __construct()
    {
        $this->code = '';
        $this->description = null;
        $this->isEnabled = true;
        $this->emailNotifications = 0;
        $this->name = '';
        $this->smsNotifications = 0;
        $this->users = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getCode();
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = strtoupper(preg_replace('/[^a-z0-9]/i', '', $code));

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

    public function getEmailNotifications(): ?int
    {
        return $this->emailNotifications;
    }

    public function setEmailNotifications(int $emailNotifications): self
    {
        $this->emailNotifications = $emailNotifications;

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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
            self::TYPE_EXISTING_ACCOUNT => self::TYPE_EXISTING_ACCOUNT,
            self::TYPE_NEW_ACCOUNT => self::TYPE_NEW_ACCOUNT,
            self::TYPE_SYSTEM => self::TYPE_SYSTEM,
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