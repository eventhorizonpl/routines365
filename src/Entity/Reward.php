<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\RewardRepository;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=RewardRepository::class)
 * @ORM\Table(indexes={@ORM\Index(name="type_idx", columns={"type"})})
 */
class Reward
{
    use Traits\IdTrait;
    use Traits\UuidTrait;
    use Traits\BlameableTrait;
    use Traits\TimestampableTrait;

    public const TYPE_ALL = 'all';
    public const TYPE_COMPLETED_ROUTINE = 'completed_routine';
    public const TYPE_COMPLETED_GOAL = 'completed_goal';

    /**
     * @Assert\Valid(groups={"system"})
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="rewards", targetEntity=Routine::class)
     */
    private ?Routine $routine;

    /**
     * @Assert\Valid(groups={"system"})
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="rewards", targetEntity=User::class)
     */
    private User $user;

    /**
     * @Assert\Length(max = 255, groups={"form", "system"})
     * @Assert\Type("string", groups={"form", "system"})
     * @ORM\Column(nullable=true, type="string")
     */
    private ?string $description;

    /**
     * @Assert\NotNull(groups={"system"})
     * @Assert\Type("bool", groups={"system"})
     * @ORM\Column(type="boolean")
     */
    private bool $isAwarded;

    /**
     * @Assert\Length(max = 64, groups={"form", "system"})
     * @Assert\NotBlank(groups={"form", "system"})
     * @Assert\Type("string", groups={"form", "system"})
     * @ORM\Column(length=64, type="string")
     */
    private string $name;

    /**
     * @Assert\GreaterThanOrEqual(0, groups={"system"})
     * @Assert\LessThanOrEqual(90, groups={"system"})
     * @Assert\NotBlank(groups={"system"})
     * @Assert\Type("int", groups={"system"})
     * @ORM\Column(type="integer")
     */
    private int $numberOfCompletions;

    /**
     * @Assert\Choice(callback="getRequiredNumberOfCompletionsValidationChoices", groups={"form", "system"})
     * @Assert\GreaterThanOrEqual(0, groups={"form", "system"})
     * @Assert\LessThanOrEqual(90, groups={"form", "system"})
     * @Assert\NotBlank(groups={"form", "system"})
     * @Assert\Type("int", groups={"form", "system"})
     * @ORM\Column(type="integer")
     */
    private int $requiredNumberOfCompletions;

    /**
     * @Assert\Choice(callback="getTypeValidationChoices", groups={"form", "system"})
     * @Assert\Length(max = 24, groups={"form", "system"})
     * @Assert\NotBlank(groups={"form", "system"})
     * @Assert\Type("string", groups={"form", "system"})
     * @ORM\Column(length=24, type="string")
     */
    private string $type;

    public function __construct()
    {
        $this->description = null;
        $this->isAwarded = false;
        $this->name = '';
        $this->numberOfCompletions = 0;
        $this->requiredNumberOfCompletions = 0;
        $this->routine = null;
    }

    public function __toString(): string
    {
        return $this->getUuid();
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

    public function getIsAwarded(): ?bool
    {
        return $this->isAwarded;
    }

    public function setIsAwarded(bool $isAwarded): self
    {
        $this->isAwarded = $isAwarded;

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

    public function incrementNumberOfCompletions(): self
    {
        $this->setNumberOfCompletions($this->getNumberOfCompletions() + 1);

        return $this;
    }

    public function getNumberOfCompletions(): ?int
    {
        return $this->numberOfCompletions;
    }

    public function getNumberOfCompletionsPercent(): ?int
    {
        return (int) (($this->getNumberOfCompletions() / $this->getRequiredNumberOfCompletions()) * 100);
    }

    public function setNumberOfCompletions(int $numberOfCompletions): self
    {
        $this->numberOfCompletions = $numberOfCompletions;

        return $this;
    }

    public function getRequiredNumberOfCompletions(): ?int
    {
        return $this->requiredNumberOfCompletions;
    }

    public static function getRequiredNumberOfCompletionsFormChoices(): array
    {
        $requiredNumberOfCompletions = [];

        for ($i = 5; $i <= 60; $i += 5) {
            $requiredNumberOfCompletions[$i] = $i;
        }

        return $requiredNumberOfCompletions;
    }

    public static function getRequiredNumberOfCompletionsValidationChoices(): array
    {
        return array_keys(self::getRequiredNumberOfCompletionsFormChoices());
    }

    public function setRequiredNumberOfCompletions(int $requiredNumberOfCompletions): self
    {
        $this->requiredNumberOfCompletions = $requiredNumberOfCompletions;

        return $this;
    }

    public function getRoutine(): ?Routine
    {
        return $this->routine;
    }

    public function setRoutine(Routine $routine): self
    {
        $this->routine = $routine;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public static function getTypeFormChoices(): array
    {
        return [
            self::TYPE_ALL => self::TYPE_ALL,
            self::TYPE_COMPLETED_ROUTINE => self::TYPE_COMPLETED_ROUTINE,
            self::TYPE_COMPLETED_GOAL => self::TYPE_COMPLETED_GOAL,
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
