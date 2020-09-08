<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    use Traits\IdTrait;
    use Traits\UuidTrait;
    use Traits\IsEnabledTrait;
    use Traits\BlameableTrait;
    use Traits\TimestampableTrait;

    public const ROLE_ADMIN = 'ROLE_ADMIN';
    public const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';
    public const ROLE_USER = 'ROLE_USER';
    public const TYPE_CUSTOMER = 'customer';
    public const TYPE_LEAD = 'lead';
    public const TYPE_PROSPECT = 'prospect';
    public const TYPE_STAFF = 'staff';

    /**
     * @Assert\Valid(groups={"form"})
     * @ORM\OneToOne(fetch="EXTRA_LAZY", mappedBy="user", targetEntity=Account::class)
     */
    private Account $account;

    /**
     * @ORM\OneToMany(fetch="EXTRA_LAZY", mappedBy="user", orphanRemoval=true, targetEntity=CompletedRoutine::class)
     * @ORM\OrderBy({"id" = "ASC"})
     */
    private Collection $completedRoutines;

    /**
     * @ORM\OneToMany(fetch="EXTRA_LAZY", mappedBy="user", orphanRemoval=true, targetEntity=Goal::class)
     */
    private Collection $goals;

    /**
     * @ORM\OneToMany(fetch="EXTRA_LAZY", mappedBy="user", orphanRemoval=true, targetEntity=Note::class)
     */
    private Collection $notes;

    /**
     * @Assert\Valid(groups={"form"})
     * @ORM\OneToOne(fetch="EXTRA_LAZY", mappedBy="user", targetEntity=Profile::class)
     */
    private Profile $profile;

    /**
     * @ORM\OneToMany(fetch="EXTRA_LAZY", mappedBy="referrer", targetEntity=User::class)
     */
    private Collection $recommendations;

    /**
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="recommendations", targetEntity=User::class)
     */
    private ?User $referrer = null;

    /**
     * @ORM\OneToMany(fetch="EXTRA_LAZY", mappedBy="user", orphanRemoval=true, targetEntity=Reminder::class)
     */
    private Collection $reminders;

    /**
     * @ORM\OneToMany(fetch="EXTRA_LAZY", mappedBy="user", orphanRemoval=true, targetEntity=Reward::class)
     */
    private Collection $rewards;

    /**
     * @ORM\OneToMany(fetch="EXTRA_LAZY", mappedBy="user", orphanRemoval=true, targetEntity=Routine::class)
     */
    private Collection $routines;

    /**
     * @Assert\Email()
     * @Assert\Length(
     *   max = 180
     * )
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @ORM\Column(length=180, type="string", unique=true)
     */
    private string $email;

    /**
     * @Assert\NotNull
     * @Assert\Type("bool")
     * @ORM\Column(type="boolean")
     */
    private bool $isVerified;

    /**
     * @Assert\Length(
     *   max = 255
     * )
     * @Assert\NotBlank(groups={"system"})
     * @Assert\NotCompromisedPassword(groups={"system"})
     * @Assert\Type("string")
     * @ORM\Column(type="string")
     */
    private string $password;

    /**
     * @Assert\NotBlank
     * @Assert\Uuid
     * @ORM\Column(type="guid", unique=true)
     */
    private string $referrerCode;

    /**
     * @Assert\Choice(callback="getRolesFormChoices", multiple=true)
     * @Assert\NotNull
     * @Assert\Type("array")
     * @ORM\Column(type="json")
     */
    private array $roles = [];

    /**
     * @Assert\Choice(callback="getTypeValidationChoices")
     * @Assert\Length(
     *   max = 8
     * )
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @ORM\Column(length=8, type="string")
     */
    private string $type;

    public function __construct()
    {
        $this->completedRoutines = new ArrayCollection();
        $this->email = '';
        $this->goals = new ArrayCollection();
        $this->isEnabled = false;
        $this->isVerified = false;
        $this->notes = new ArrayCollection();
        $this->recommendations = new ArrayCollection();
        $this->referrer = null;
        $this->reminders = new ArrayCollection();
        $this->rewards = new ArrayCollection();
        $this->routines = new ArrayCollection();
        $this->type = self::TYPE_PROSPECT;
    }

    public function __serialize(): array
    {
        return [
            'account' => $this->getAccount(),
            'completedRoutines' => $this->getCompletedRoutinesAll(),
            'createdAt' => $this->getCreatedAt(),
            'createdBy' => $this->getCreatedBy(),
            'deletedAt' => $this->getDeletedAt(),
            'deletedBy' => $this->getDeletedBy(),
            'goals' => $this->getGoalsAll(),
            'id' => $this->getId(),
            'isEnabled' => $this->getIsEnabled(),
            'isVerified' => $this->getIsVerified(),
            'notes' => $this->getNotesAll(),
            'profile' => $this->getProfile(),
            'recommendations' => $this->getRecommendationsAll(),
            'reminders' => $this->getRemindersAll(),
            'rewards' => $this->getRewardsAll(),
            'routines' => $this->getRoutinesAll(),
            'email' => $this->getEmail(),
            'password' => $this->getPassword(),
            'referrerCode' => $this->getReferrerCode(),
            'roles' => $this->getRoles(),
            'updatedAt' => $this->getUpdatedAt(),
            'updatedBy' => $this->getUpdatedBy(),
            'uuid' => $this->getUuid(),
        ];
    }

    public function __toString(): string
    {
        return $this->getUuid();
    }

    public function __unserialize(array $data): void
    {
        $this->account = $data['account'];
        $this->completedRoutines = $data['completedRoutines'];
        $this->createdAt = $data['createdAt'];
        $this->createdBy = $data['createdBy'];
        $this->deletedAt = $data['deletedAt'];
        $this->deletedBy = $data['deletedBy'];
        $this->goals = $data['goals'];
        $this->notes = $data['notes'];
        $this->id = $data['id'];
        $this->isEnabled = $data['isEnabled'];
        $this->isVerified = $data['isVerified'];
        $this->profile = $data['profile'];
        $this->recommendations = $data['recommendations'];
        $this->reminders = $data['reminders'];
        $this->rewards = $data['rewards'];
        $this->routines = $data['routines'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->referrerCode = $data['referrerCode'];
        $this->roles = $data['roles'];
        $this->updatedAt = $data['updatedAt'];
        $this->updatedBy = $data['updatedBy'];
        $this->uuid = $data['uuid'];
    }

    public function getAccount(): Account
    {
        return $this->account;
    }

    public function setAccount(Account $account): self
    {
        $this->account = $account;

        return $this;
    }

    public function addCompletedRoutine(CompletedRoutine $completedRoutine): self
    {
        if (false === $this->completedRoutines->contains($completedRoutine)) {
            $this->completedRoutines->add($completedRoutine);
            $completedRoutine->setUser($this);
        }

        return $this;
    }

    public function getCompletedRoutines(): Collection
    {
        return $this->completedRoutines->filter(function (CompletedRoutine $completedRoutine) {
            return null === $completedRoutine->getDeletedAt();
        });
    }

    public function getCompletedRoutinesAll(): Collection
    {
        return $this->completedRoutines;
    }

    public function removeCompletedRoutine(CompletedRoutine $completedRoutine): self
    {
        if (true === $this->completedRoutines->contains($completedRoutine)) {
            $this->completedRoutines->removeElement($completedRoutine);
        }

        return $this;
    }

    public function eraseCredentials()
    {
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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
        return $this->goals->filter(function (Goal $goal) {
            return null === $goal->getDeletedAt();
        });
    }

    public function getGoalsAll(): Collection
    {
        return $this->goals;
    }

    public function removeGoal(Goal $goal): self
    {
        if (true === $this->goals->contains($goal)) {
            $this->goals->removeElement($goal);
        }

        return $this;
    }

    public function getIsVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function addNote(Note $note): self
    {
        if (false === $this->notes->contains($note)) {
            $this->notes->add($note);
            $note->setUser($this);
        }

        return $this;
    }

    public function getNotes(): Collection
    {
        return $this->notes->filter(function (Note $note) {
            return null === $note->getDeletedAt();
        });
    }

    public function getNotesAll(): Collection
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

    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getProfile(): Profile
    {
        return $this->profile;
    }

    public function setProfile(Profile $profile): self
    {
        $this->profile = $profile;

        return $this;
    }

    public function addRecommendation(self $recommendation): self
    {
        if (false === $this->recommendations->contains($note)) {
            $this->recommendations->add($recommendation);
            $recommendation->setReferrer($this);
        }

        return $this;
    }

    public function getRecommendations(): Collection
    {
        return $this->recommendations->filter(function (self $recommendation) {
            return null === $recommendation->getDeletedAt();
        });
    }

    public function getRecommendationsAll(): Collection
    {
        return $this->recommendations;
    }

    public function removeRecommendation(self $recommendation): self
    {
        if (true === $this->recommendations->contains($recommendation)) {
            $this->recommendations->removeElement($recommendation);
        }

        return $this;
    }

    public function getReferrer(): ?User
    {
        return $this->referrer;
    }

    public function setReferrer(?User $referrer): self
    {
        $this->referrer = $referrer;

        return $this;
    }

    public function getReferrerCode(): ?string
    {
        return $this->referrerCode;
    }

    public function setReferrerCode(string $referrerCode): self
    {
        $this->referrerCode = $referrerCode;

        return $this;
    }

    public function addReminder(Reminder $reminder): self
    {
        if (false === $this->reminders->contains($reminder)) {
            $this->reminders->add($reminder);
            $reminder->setUser($this);
        }

        return $this;
    }

    public function getReminders(): Collection
    {
        return $this->reminders->filter(function (Reminder $reminder) {
            return null === $reminder->getDeletedAt();
        });
    }

    public function getRemindersAll(): Collection
    {
        return $this->reminders;
    }

    public function removeReminder(Reminder $reminder): self
    {
        if (true === $this->reminders->contains($reminder)) {
            $this->reminders->removeElement($reminder);
        }

        return $this;
    }

    public function addReward(Reward $reward): self
    {
        if (false === $this->rewards->contains($reward)) {
            $this->rewards->add($reward);
            $reward->setUser($this);
        }

        return $this;
    }

    public function getRewards(): Collection
    {
        return $this->rewards->filter(function (Reward $reward) {
            return null === $reward->getDeletedAt();
        });
    }

    public function getRewardsAll(): Collection
    {
        return $this->rewards;
    }

    public function removeReward(Reward $reward): self
    {
        if (true === $this->rewards->contains($reward)) {
            $this->rewards->removeElement($reward);
        }

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = self::ROLE_USER;

        return array_unique($roles);
    }

    public static function getRolesFormChoices(): array
    {
        return [
            self::ROLE_ADMIN => self::ROLE_ADMIN,
            self::ROLE_SUPER_ADMIN => self::ROLE_SUPER_ADMIN,
            self::ROLE_USER => self::ROLE_USER,
        ];
    }

    public static function getRolesValidationChoices(): array
    {
        return array_keys(self::getRolesFormChoices());
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function addRoutine(Routine $routine): self
    {
        if (false === $this->routines->contains($routine)) {
            $this->routines->add($routine);
            $routine->setUser($this);
        }

        return $this;
    }

    public function getRoutines(): Collection
    {
        return $this->routines->filter(function (Routine $routine) {
            return null === $routine->getDeletedAt();
        });
    }

    public function getRoutinesAll(): Collection
    {
        return $this->routines;
    }

    public function removeRoutine(Routine $routine): self
    {
        if (true === $this->routines->contains($routine)) {
            $this->routines->removeElement($routine);
        }

        return $this;
    }

    public function getSalt()
    {
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public static function getTypeFormChoices(): array
    {
        return [
            self::TYPE_CUSTOMER => self::TYPE_CUSTOMER,
            self::TYPE_LEAD => self::TYPE_LEAD,
            self::TYPE_PROSPECT => self::TYPE_PROSPECT,
            self::TYPE_STAFF => self::TYPE_STAFF,
        ];
    }

    public static function getTypeValidationChoices(): array
    {
        return array_keys(self::getTypeFormChoices());
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getUsername(): string
    {
        return (string) $this->email;
    }
}
