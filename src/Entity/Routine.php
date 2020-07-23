<?php

namespace App\Entity;

use App\Repository\RoutineRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=RoutineRepository::class)
 */
class Routine
{
    use Traits\IdTrait;
    use Traits\UuidTrait;
    use Traits\IsEnabledTrait;
    use Traits\BlameableTrait;
    use Traits\TimestampableTrait;

    public const TYPE_HOBBY = 'hobby';
    public const TYPE_LEARNING = 'learning';
    public const TYPE_SPORT = 'sport';
    public const TYPE_WORK = 'work';

    /**
     * @Assert\Valid
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="routines", targetEntity=User::class)
     */
    private User $user;

    /**
     * @Assert\Length(
     *   max = 255
     * )
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @ORM\Column(nullable=true, type="string")
     */
    private ?string $description;

    /**
     * @Assert\Length(
     *   max = 64
     * )
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @ORM\Column(length=64, type="string")
     */
    private string $name;

    /**
     * @Assert\Choice(callback="getTypeValidationChoices")
     * @Assert\Length(
     *   max = 16
     * )
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @ORM\Column(length=16, type="string")
     */
    private string $type;

    public function __construct()
    {
        $this->description = null;
        $this->isEnabled = false;
        $this->name = '';
        $this->type = self::TYPE_HOBBY;
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public static function getTypeFormChoices(): array
    {
        return [
            self::TYPE_HOBBY => self::TYPE_HOBBY,
            self::TYPE_LEARNING => self::TYPE_LEARNING,
            self::TYPE_SPORT => self::TYPE_SPORT,
            self::TYPE_WORK => self::TYPE_WORK,
        ];
    }

    public function getTypeValidationChoices(): array
    {
        return [
            self::TYPE_HOBBY,
            self::TYPE_LEARNING,
            self::TYPE_SPORT,
            self::TYPE_WORK,
        ];
    }

    public function setType(string $type): self
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
