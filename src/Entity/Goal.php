<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\GoalRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=GoalRepository::class)
 */
class Goal
{
    use Traits\BlameableTrait;
    use Traits\IdTrait;
    use Traits\IsCompletedTrait;
    use Traits\TimestampableTrait;
    use Traits\UuidTrait;

    public const CONTEXT_PROJECT = 'project';
    public const CONTEXT_ROUTINE = 'routine';

    /**
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="goals", targetEntity=Project::class)
     */
    #[Assert\Valid(groups: ['system'])]
    private ?Project $project;

    /**
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="goals", targetEntity=Routine::class)
     */
    #[Assert\Valid(groups: ['system'])]
    private Routine $routine;

    /**
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="goals", targetEntity=User::class)
     */
    #[Assert\Valid(groups: ['system'])]
    private User $user;

    /**
     * @ORM\Column(nullable=true, type="string")
     */
    #[Assert\Length(groups: ['form', 'system'], max: 255)]
    #[Assert\Type('string', groups: ['form', 'system'])]
    #[Groups(['gdpr'])]
    private ?string $description;

    /**
     * @ORM\Column(length=64, type="string")
     */
    #[Assert\Length(groups: ['form', 'system'], max: 64)]
    #[Assert\NotBlank(groups: ['form', 'system'])]
    #[Assert\Type('string', groups: ['form', 'system'])]
    #[Groups(['gdpr'])]
    private ?string $name;

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

    public function setName(?string $name): self
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
