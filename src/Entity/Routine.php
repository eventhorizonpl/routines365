<?php

namespace App\Entity;

use App\Repository\RoutineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\OneToMany(fetch="EXTRA_LAZY", mappedBy="routine", orphanRemoval=true, targetEntity=Goal::class)
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private Collection $goals;

    /**
     * @ORM\OneToMany(fetch="EXTRA_LAZY", mappedBy="routine", orphanRemoval=true, targetEntity=Note::class)
     */
    private Collection $notes;

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
        $this->goals = new ArrayCollection();
        $this->isEnabled = false;
        $this->name = '';
        $this->notes = new ArrayCollection();
        $this->type = self::TYPE_HOBBY;
    }

    public function __toString(): string
    {
        return $this->getName();
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

    public function addGoal(Goal $goal): self
    {
        if (false === $this->goals->contains($goal)) {
            $this->goals->add($goal);
            $goal->setUser($this);
        }

        return $this;
    }

    public function getGoals(): Collection
    {
        return $this->goals;
    }

    public function getGoalsCompleted(): Collection
    {
        return $this->goals->filter(function(Goal $goal) {
            return ((true === $goal->getIsCompleted()) && (null === $goal->getDeletedAt()));
        });
    }

    public function getGoalsCompletedCount(): int
    {
        $goalsCompleted = 0;
        foreach ($this->goals as $goal) {
            if ((true === $goal->getIsCompleted()) && (null === $goal->getDeletedAt())) {
                ++$goalsCompleted;
            }
        }

        return $goalsCompleted;
    }

    public function getGoalsNotCompleted(): Collection
    {
        return $this->goals->filter(function(Goal $goal) {
            return ((false === $goal->getIsCompleted()) && (null === $goal->getDeletedAt()));
        });
    }

    public function getGoalsNotCompletedCount(): int
    {
        $goalsNotCompleted = 0;
        foreach ($this->goals as $goal) {
            if ((false === $goal->getIsCompleted()) && (null === $goal->getDeletedAt())) {
                ++$goalsNotCompleted;
            }
        }

        return $goalsNotCompleted;
    }

    public function removeGoal(Goal $goal): self
    {
        if (true === $this->goals->contains($goal)) {
            $this->goals->removeElement($goal);
        }

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

    public function addNote(Note $note): self
    {
        if (false === $this->notes->contains($note)) {
            $this->notes->add($note);
            $goal->setUser($this);
        }

        return $this;
    }

    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function removeNote(Note $note): self
    {
        if (true === $this->notes->contains($note)) {
            $this->notes->removeElement($note);
        }

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
