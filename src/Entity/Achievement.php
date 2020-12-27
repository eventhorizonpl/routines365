<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AchievementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AchievementRepository::class)
 * @ORM\Table(indexes={@ORM\Index(name="type_idx", columns={"type"})})
 */
class Achievement
{
    use Traits\IdTrait;
    use Traits\UuidTrait;
    use Traits\IsEnabledTrait;
    use Traits\BlameableTrait;
    use Traits\TimestampableTrait;

    public const TYPE_COMPLETED_ROUTINE = 'completed_routine';
    public const TYPE_COMPLETED_GOAL = 'completed_goal';
    public const TYPE_COMPLETED_PROJECT = 'completed_project';
    public const TYPE_CREATED_NOTE = 'created_note';

    /**
     * @ORM\ManyToMany(fetch="EXTRA_LAZY", mappedBy="achievements", targetEntity=User::class)
     */
    private Collection $users;

    /**
     * @Assert\Length(max = 255, groups={"system"})
     * @Assert\Type("string", groups={"system"})
     * @ORM\Column(nullable=true, type="string")
     */
    private ?string $description;

    /**
     * @Assert\GreaterThanOrEqual(1, groups={"system"})
     * @Assert\LessThanOrEqual(10, groups={"system"})
     * @Assert\NotBlank(groups={"system"})
     * @Assert\Type("int", groups={"system"})
     * @ORM\Column(type="integer")
     */
    private int $level;

    /**
     * @Assert\Length(max = 64, groups={"system"})
     * @Assert\NotBlank(groups={"system"})
     * @Assert\Type("string", groups={"system"})
     * @ORM\Column(length=64, type="string")
     */
    private string $name;

    /**
     * @Assert\GreaterThanOrEqual(1, groups={"system"})
     * @Assert\LessThanOrEqual(1000, groups={"system"})
     * @Assert\NotBlank(groups={"system"})
     * @Assert\Type("int", groups={"system"})
     * @ORM\Column(type="integer")
     */
    private int $requirement;

    /**
     * @Assert\Choice(callback="getTypeValidationChoices", groups={"system"})
     * @Assert\Length(max = 24, groups={"system"})
     * @Assert\NotBlank(groups={"system"})
     * @Assert\Type("string", groups={"system"})
     * @ORM\Column(length=24, type="string")
     */
    private string $type;

    public function __construct()
    {
        $this->description = null;
        $this->isEnabled = true;
        $this->level = 0;
        $this->name = '';
        $this->users = new ArrayCollection();
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getRequirement(): ?int
    {
        return $this->requirement;
    }

    public function setRequirement(int $requirement): self
    {
        $this->requirement = $requirement;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public static function getTypeFormChoices(): array
    {
        return [
            self::TYPE_COMPLETED_ROUTINE => self::TYPE_COMPLETED_ROUTINE,
            self::TYPE_COMPLETED_GOAL => self::TYPE_COMPLETED_GOAL,
            self::TYPE_COMPLETED_PROJECT => self::TYPE_COMPLETED_PROJECT,
            self::TYPE_CREATED_NOTE => self::TYPE_CREATED_NOTE,
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
