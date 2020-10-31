<?php

namespace App\Entity;

use App\Repository\GoalRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=GoalRepository::class)
 */
class Goal
{
    use Traits\IdTrait;
    use Traits\UuidTrait;
    use Traits\IsCompletedTrait;
    use Traits\BlameableTrait;
    use Traits\TimestampableTrait;

    public const CONTEXT_PROJECT = 'project';
    public const CONTEXT_ROUTINE = 'routine';

    /**
     * @Assert\Valid
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="goals", targetEntity=Project::class)
     */
    private ?Project $project;

    /**
     * @Assert\Valid
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="goals", targetEntity=Routine::class)
     */
    private Routine $routine;

    /**
     * @Assert\Valid
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="goals", targetEntity=User::class)
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

    public function __construct()
    {
        $this->description = null;
        $this->isCompleted = false;
        $this->name = '';
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

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project = null): self
    {
        $this->project = $project;

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
