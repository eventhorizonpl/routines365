<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserKytRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserKytRepository::class)
 */
class UserKyt
{
    use Traits\BlameableTrait;
    use Traits\IdTrait;
    use Traits\TimestampableTrait;
    use Traits\UuidTrait;

    /**
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\OneToOne(fetch="EXTRA_LAZY", inversedBy="userKyt", targetEntity=User::class)
     */
    private User $user;

    /**
     * @ORM\Column(type="boolean")
     */
    #[Assert\NotNull(groups: ['system'])]
    #[Assert\Type('bool', groups: ['system'])]
    private bool $basicConfigurationLearned;

    /**
     * @ORM\Column(type="boolean")
     */
    #[Assert\NotNull(groups: ['system'])]
    #[Assert\Type('bool', groups: ['system'])]
    private bool $basicConfigurationSent;

    /**
     * @ORM\Column(type="boolean")
     */
    #[Assert\NotNull(groups: ['system'])]
    #[Assert\Type('bool', groups: ['system'])]
    private bool $completingRoutinesLearned;

    /**
     * @ORM\Column(type="boolean")
     */
    #[Assert\NotNull(groups: ['system'])]
    #[Assert\Type('bool', groups: ['system'])]
    private bool $completingRoutinesSent;

    /**
     * @ORM\Column(nullable=true, type="datetimetz_immutable")
     */
    #[Assert\Type('DateTimeImmutable', groups: ['system'])]
    private ?DateTimeImmutable $dateOfLastMessage = null;

    /**
     * @ORM\Column(type="boolean")
     */
    #[Assert\NotNull(groups: ['system'])]
    #[Assert\Type('bool', groups: ['system'])]
    private bool $goalsLearned;

    /**
     * @ORM\Column(type="boolean")
     */
    #[Assert\NotNull(groups: ['system'])]
    #[Assert\Type('bool', groups: ['system'])]
    private bool $goalsSent;

    /**
     * @ORM\Column(type="boolean")
     */
    #[Assert\NotNull(groups: ['system'])]
    #[Assert\Type('bool', groups: ['system'])]
    private bool $notesLearned;

    /**
     * @ORM\Column(type="boolean")
     */
    #[Assert\NotNull(groups: ['system'])]
    #[Assert\Type('bool', groups: ['system'])]
    private bool $notesSent;

    /**
     * @ORM\Column(type="boolean")
     */
    #[Assert\NotNull(groups: ['system'])]
    #[Assert\Type('bool', groups: ['system'])]
    private bool $projectsLearned;

    /**
     * @ORM\Column(type="boolean")
     */
    #[Assert\NotNull(groups: ['system'])]
    #[Assert\Type('bool', groups: ['system'])]
    private bool $projectsSent;

    /**
     * @ORM\Column(type="boolean")
     */
    #[Assert\NotNull(groups: ['system'])]
    #[Assert\Type('bool', groups: ['system'])]
    private bool $remindersLearned;

    /**
     * @ORM\Column(type="boolean")
     */
    #[Assert\NotNull(groups: ['system'])]
    #[Assert\Type('bool', groups: ['system'])]
    private bool $remindersSent;

    /**
     * @ORM\Column(type="boolean")
     */
    #[Assert\NotNull(groups: ['system'])]
    #[Assert\Type('bool', groups: ['system'])]
    private bool $rewardsLearned;

    /**
     * @ORM\Column(type="boolean")
     */
    #[Assert\NotNull(groups: ['system'])]
    #[Assert\Type('bool', groups: ['system'])]
    private bool $rewardsSent;

    /**
     * @ORM\Column(type="boolean")
     */
    #[Assert\NotNull(groups: ['system'])]
    #[Assert\Type('bool', groups: ['system'])]
    private bool $routinesLearned;

    /**
     * @ORM\Column(type="boolean")
     */
    #[Assert\NotNull(groups: ['system'])]
    #[Assert\Type('bool', groups: ['system'])]
    private bool $routinesSent;

    /**
     * @ORM\Column(type="boolean")
     */
    #[Assert\NotNull(groups: ['system'])]
    #[Assert\Type('bool', groups: ['system'])]
    private bool $testimonialRequestSent;

    public function __construct()
    {
        $this->basicConfigurationLearned = false;
        $this->basicConfigurationSent = false;
        $this->completingRoutinesLearned = false;
        $this->completingRoutinesSent = false;
        $this->goalsLearned = false;
        $this->goalsSent = false;
        $this->notesLearned = false;
        $this->notesSent = false;
        $this->projectsLearned = false;
        $this->projectsSent = false;
        $this->remindersLearned = false;
        $this->remindersSent = false;
        $this->rewardsLearned = false;
        $this->rewardsSent = false;
        $this->routinesLearned = false;
        $this->routinesSent = false;
        $this->testimonialRequestSent = false;
    }

    public function __toString(): string
    {
        return $this->getUuid();
    }

    public function getBasicConfigurationLearned(): ?bool
    {
        return $this->basicConfigurationLearned;
    }

    public function setBasicConfigurationLearned(bool $basicConfigurationLearned): self
    {
        $this->basicConfigurationLearned = $basicConfigurationLearned;

        return $this;
    }

    public function getBasicConfigurationSent(): ?bool
    {
        return $this->basicConfigurationSent;
    }

    public function setBasicConfigurationSent(bool $basicConfigurationSent): self
    {
        $this->basicConfigurationSent = $basicConfigurationSent;

        return $this;
    }

    public function getCompletingRoutinesLearned(): ?bool
    {
        return $this->completingRoutinesLearned;
    }

    public function setCompletingRoutinesLearned(bool $completingRoutinesLearned): self
    {
        $this->completingRoutinesLearned = $completingRoutinesLearned;

        return $this;
    }

    public function getCompletingRoutinesSent(): ?bool
    {
        return $this->completingRoutinesSent;
    }

    public function setCompletingRoutinesSent(bool $completingRoutinesSent): self
    {
        $this->completingRoutinesSent = $completingRoutinesSent;

        return $this;
    }

    public function getDateOfLastMessage(): ?DateTimeImmutable
    {
        return $this->dateOfLastMessage;
    }

    public function setDateOfLastMessage(DateTimeImmutable $dateOfLastMessage): self
    {
        $this->dateOfLastMessage = $dateOfLastMessage;

        return $this;
    }

    public function getGoalsLearned(): ?bool
    {
        return $this->goalsLearned;
    }

    public function setGoalsLearned(bool $goalsLearned): self
    {
        $this->goalsLearned = $goalsLearned;

        return $this;
    }

    public function getGoalsSent(): ?bool
    {
        return $this->goalsSent;
    }

    public function setGoalsSent(bool $goalsSent): self
    {
        $this->goalsSent = $goalsSent;

        return $this;
    }

    public function getNotesLearned(): ?bool
    {
        return $this->notesLearned;
    }

    public function setNotesLearned(bool $notesLearned): self
    {
        $this->notesLearned = $notesLearned;

        return $this;
    }

    public function getNotesSent(): ?bool
    {
        return $this->notesSent;
    }

    public function setNotesSent(bool $notesSent): self
    {
        $this->notesSent = $notesSent;

        return $this;
    }

    public function getProjectsLearned(): ?bool
    {
        return $this->projectsLearned;
    }

    public function setProjectsLearned(bool $projectsLearned): self
    {
        $this->projectsLearned = $projectsLearned;

        return $this;
    }

    public function getProjectsSent(): ?bool
    {
        return $this->projectsSent;
    }

    public function setProjectsSent(bool $projectsSent): self
    {
        $this->projectsSent = $projectsSent;

        return $this;
    }

    public function getRemindersLearned(): ?bool
    {
        return $this->remindersLearned;
    }

    public function setRemindersLearned(bool $remindersLearned): self
    {
        $this->remindersLearned = $remindersLearned;

        return $this;
    }

    public function getRemindersSent(): ?bool
    {
        return $this->remindersSent;
    }

    public function setRemindersSent(bool $remindersSent): self
    {
        $this->remindersSent = $remindersSent;

        return $this;
    }

    public function getRewardsLearned(): ?bool
    {
        return $this->rewardsLearned;
    }

    public function setRewardsLearned(bool $rewardsLearned): self
    {
        $this->rewardsLearned = $rewardsLearned;

        return $this;
    }

    public function getRewardsSent(): ?bool
    {
        return $this->rewardsSent;
    }

    public function setRewardsSent(bool $rewardsSent): self
    {
        $this->rewardsSent = $rewardsSent;

        return $this;
    }

    public function getRoutinesLearned(): ?bool
    {
        return $this->routinesLearned;
    }

    public function setRoutinesLearned(bool $routinesLearned): self
    {
        $this->routinesLearned = $routinesLearned;

        return $this;
    }

    public function getRoutinesSent(): ?bool
    {
        return $this->routinesSent;
    }

    public function setRoutinesSent(bool $routinesSent): self
    {
        $this->routinesSent = $routinesSent;

        return $this;
    }

    public function getTestimonialRequestSent(): ?bool
    {
        return $this->testimonialRequestSent;
    }

    public function setTestimonialRequestSent(bool $testimonialRequestSent): self
    {
        $this->testimonialRequestSent = $testimonialRequestSent;

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
