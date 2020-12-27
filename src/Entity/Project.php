<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
{
    use Traits\IdTrait;
    use Traits\UuidTrait;
    use Traits\IsCompletedTrait;
    use Traits\BlameableTrait;
    use Traits\TimestampableTrait;

    /**
     * @ORM\OneToMany(fetch="EXTRA_LAZY", mappedBy="project", orphanRemoval=true, targetEntity=Goal::class)
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private Collection $goals;

    /**
     * @Assert\Valid(groups={"system"})
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="projects", targetEntity=User::class)
     */
    private User $user;

    /**
     * @Assert\Length(max = 255, groups={"system"})
     * @Assert\Type("string", groups={"system"})
     * @ORM\Column(nullable=true, type="string")
     */
    private ?string $description;

    /**
     * @Assert\Length(max = 64, groups={"system"})
     * @Assert\NotBlank(groups={"system"})
     * @Assert\Type("string", groups={"system"})
     * @ORM\Column(length=64, type="string")
     */
    private string $name;

    public function __construct()
    {
        $this->description = null;
        $this->goals = new ArrayCollection();
        $this->isCompleted = false;
        $this->name = '';
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
            $goal->setProject($this);
        }

        return $this;
    }

    public function getGoals(): Collection
    {
        return $this->goals->filter(function (Goal $goal) {
            return null === $goal->getDeletedAt();
        });
    }

    public function getGoalsAll(): Collection
    {
        return $this->goals;
    }

    public function getGoalsCompleted(): Collection
    {
        return $this->goals->filter(function (Goal $goal) {
            return (true === $goal->getIsCompleted()) && (null === $goal->getDeletedAt());
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

    public function getGoalsCompletedPercent(): int
    {
        $goalsCompleted = $this->getGoalsCompletedCount();
        $goalsNotCompleted = $this->getGoalsNotCompletedCount();

        $total = $goalsCompleted + $goalsNotCompleted;

        if ($total > 0) {
            return (int) (($goalsCompleted / $total) * 100);
        } else {
            return 0;
        }
    }

    public function getGoalsNotCompleted(): Collection
    {
        return $this->goals->filter(function (Goal $goal) {
            return (false === $goal->getIsCompleted()) && (null === $goal->getDeletedAt());
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

    public function getGoalsNotCompletedPercent(): int
    {
        $goalsCompleted = $this->getGoalsCompletedCount();
        $goalsNotCompleted = $this->getGoalsNotCompletedCount();

        $total = $goalsCompleted + $goalsNotCompleted;

        if ($total > 0) {
            return (int) (($goalsNotCompleted / $total) * 100);
        } else {
            return 0;
        }
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
