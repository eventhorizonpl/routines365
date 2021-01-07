<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
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
    use Traits\IsVerifiedTrait;
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
     * @ORM\ManyToMany(fetch="EXTRA_LAZY", inversedBy="users", targetEntity=Achievement::class)
     */
    private Collection $achievements;

    /**
     * @ORM\OneToMany(fetch="EXTRA_LAZY", mappedBy="user", orphanRemoval=true, targetEntity=CompletedRoutine::class)
     * @ORM\OrderBy({"id" = "ASC"})
     */
    private Collection $completedRoutines;

    /**
     * @ORM\OneToMany(fetch="EXTRA_LAZY", mappedBy="user", orphanRemoval=true, targetEntity=Contact::class)
     */
    private Collection $contacts;

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
     * @ORM\OneToMany(fetch="EXTRA_LAZY", mappedBy="user", orphanRemoval=true, targetEntity=Project::class)
     */
    private Collection $projects;

    /**
     * @ORM\ManyToMany(fetch="EXTRA_LAZY", inversedBy="users", targetEntity=Promotion::class)
     */
    private Collection $promotions;

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
     * @ORM\OneToMany(fetch="EXTRA_LAZY", mappedBy="user", orphanRemoval=true, targetEntity=SavedEmail::class)
     */
    private Collection $savedEmails;

    /**
     * @ORM\OneToMany(fetch="EXTRA_LAZY", mappedBy="user", orphanRemoval=true, targetEntity=UserKpi::class)
     */
    private Collection $userKpis;

    /**
     * @ORM\OneToMany(fetch="EXTRA_LAZY", mappedBy="user", orphanRemoval=true, targetEntity=UserQuestionnaire::class)
     */
    private Collection $userQuestionnaires;

    /**
     * @Assert\Email(groups={"form", "system"})
     * @Assert\Length(max = 180, groups={"form", "system"})
     * @Assert\NotBlank(groups={"form", "system"})
     * @Assert\Type("string", groups={"form", "system"})
     * @ORM\Column(length=180, type="string", unique=true)
     */
    private string $email;

    /**
     * @Assert\Type("DateTimeImmutable", groups={"system"})
     * @ORM\Column(nullable=true, type="datetimetz_immutable")
     */
    protected $lastLoginAt;

    /**
     * @Assert\Length(max = 255, groups={"system"})
     * @Assert\NotBlank(groups={"system"})
     * @Assert\Type("string", groups={"system"})
     * @ORM\Column(type="string")
     */
    private string $password;

    /**
     * @Assert\NotBlank(groups={"system"})
     * @Assert\Uuid(groups={"system"})
     * @ORM\Column(type="guid", unique=true)
     */
    private string $referrerCode;

    /**
     * @Assert\Choice(callback="getRolesFormChoices", multiple=true, groups={"system"})
     * @Assert\NotNull(groups={"system"})
     * @Assert\Type("array", groups={"system"})
     * @ORM\Column(type="json")
     */
    private array $roles = [];

    /**
     * @Assert\Choice(callback="getTypeValidationChoices", groups={"system"})
     * @Assert\Length(max = 8, groups={"system"})
     * @Assert\NotBlank(groups={"system"})
     * @Assert\Type("string", groups={"system"})
     * @ORM\Column(length=8, type="string")
     */
    private string $type;

    public function __construct()
    {
        $this->achievements = new ArrayCollection();
        $this->completedRoutines = new ArrayCollection();
        $this->contacts = new ArrayCollection();
        $this->email = '';
        $this->goals = new ArrayCollection();
        $this->isEnabled = false;
        $this->isVerified = false;
        $this->notes = new ArrayCollection();
        $this->projects = new ArrayCollection();
        $this->promotions = new ArrayCollection();
        $this->recommendations = new ArrayCollection();
        $this->referrer = null;
        $this->reminders = new ArrayCollection();
        $this->rewards = new ArrayCollection();
        $this->routines = new ArrayCollection();
        $this->savedEmails = new ArrayCollection();
        $this->type = self::TYPE_PROSPECT;
        $this->userKpis = new ArrayCollection();
        $this->userQuestionnaires = new ArrayCollection();
    }

    public function __serialize(): array
    {
        return [
            'id' => $this->getId(),
            'email' => $this->getEmail(),
            'password' => $this->getPassword(),
        ];
    }

    public function __toString(): string
    {
        return $this->getUuid();
    }

    public function __unserialize(array $data): void
    {
        $this->id = $data['id'];
        $this->email = $data['email'];
        $this->password = $data['password'];
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

    public function addAchievement(Achievement $achievement): self
    {
        if (false === $this->achievements->contains($achievement)) {
            $this->achievements->add($achievement);
        }

        return $this;
    }

    public function getAchievements(): Collection
    {
        return $this->achievements;
    }

    public function hasAchievement(Achievement $achievement): bool
    {
        if (true === $this->achievements->contains($achievement)) {
            return true;
        } else {
            return false;
        }
    }

    public function removeAchievement(Achievement $achievement): self
    {
        if (true === $this->achievements->contains($achievement)) {
            $this->achievements->removeElement($achievement);
        }

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

    public function addContact(Contact $contact): self
    {
        if (false === $this->contacts->contains($contact)) {
            $this->contacts->add($contact);
            $contact->setUser($this);
        }

        return $this;
    }

    public function getContacts(): Collection
    {
        return $this->contacts->filter(function (Contact $contact) {
            return null === $contact->getDeletedAt();
        });
    }

    public function getContactsAll(): Collection
    {
        return $this->contacts;
    }

    public function removeContact(Contact $contact): self
    {
        if (true === $this->contacts->contains($contact)) {
            $this->contacts->removeElement($contact);
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

    public function getGoalsCompleted(): Collection
    {
        return $this->goals->filter(function (Goal $goal) {
            return (true === $goal->getIsCompleted()) && (null === $goal->getDeletedAt());
        });
    }

    public function removeGoal(Goal $goal): self
    {
        if (true === $this->goals->contains($goal)) {
            $this->goals->removeElement($goal);
        }

        return $this;
    }

    public function getLastLoginAt(): ?DateTimeImmutable
    {
        return $this->lastLoginAt;
    }

    public function setLastLoginAt(?DateTimeImmutable $lastLoginAt): self
    {
        $this->lastLoginAt = $lastLoginAt;

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

    public function addProject(Project $project): self
    {
        if (false === $this->projects->contains($project)) {
            $this->projects->add($project);
            $project->setUser($this);
        }

        return $this;
    }

    public function getProjects(): Collection
    {
        return $this->projects->filter(function (Project $project) {
            return null === $project->getDeletedAt();
        });
    }

    public function getProjectsAll(): Collection
    {
        return $this->projects;
    }

    public function getProjectsCompleted(): Collection
    {
        return $this->projects->filter(function (Project $project) {
            return (true === $project->getIsCompleted()) && (null === $project->getDeletedAt());
        });
    }

    public function removeProject(Project $project): self
    {
        if (true === $this->projects->contains($project)) {
            $this->projects->removeElement($project);
        }

        return $this;
    }

    public function addPromotion(Promotion $promotion): self
    {
        if (false === $this->promotions->contains($promotion)) {
            $this->promotions->add($promotion);
        }

        return $this;
    }

    public function getPromotions(): Collection
    {
        return $this->promotions;
    }

    public function hasPromotion(Promotion $promotion): bool
    {
        if (true === $this->promotions->contains($promotion)) {
            return true;
        } else {
            return false;
        }
    }

    public function removePromotion(Promotion $promotion): self
    {
        if (true === $this->promotions->contains($promotion)) {
            $this->promotions->removeElement($promotion);
        }

        return $this;
    }

    public function addRecommendation(self $recommendation): self
    {
        if (false === $this->recommendations->contains($recommendation)) {
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

    public function getRewardsAwarded(): Collection
    {
        return $this->rewards->filter(function (Reward $reward) {
            return (true === $reward->getIsAwarded()) && (null === $reward->getDeletedAt());
        });
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

    public function addSavedEmail(SavedEmail $savedEmail): self
    {
        if (false === $this->savedEmails->contains($savedEmail)) {
            $this->savedEmails->add($savedEmail);
            $savedEmail->setUser($this);
        }

        return $this;
    }

    public function getSavedEmails(): Collection
    {
        return $this->savedEmails->filter(function (SavedEmail $savedEmail) {
            return null === $savedEmail->getDeletedAt();
        });
    }

    public function getSavedEmailsAll(): Collection
    {
        return $this->savedEmails;
    }

    public function removeSavedEmail(SavedEmail $savedEmail): self
    {
        if (true === $this->savedEmails->contains($savedEmail)) {
            $this->savedEmails->removeElement($savedEmail);
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
        if (!(in_array($type, self::getTypeValidationChoices()))) {
            throw new InvalidArgumentException('Invalid type');
        }

        $this->type = $type;

        return $this;
    }

    public function addUserKpi(UserKpi $userKpi): self
    {
        if (false === $this->userKpis->contains($userKpi)) {
            $this->userKpis->add($userKpi);
            $userKpi->setUser($this);
        }

        return $this;
    }

    public function getUserKpis(): Collection
    {
        return $this->userKpis->filter(function (UserKpi $userKpi) {
            return null === $userKpi->getDeletedAt();
        });
    }

    public function getUserKpisAll(): Collection
    {
        return $this->userKpis;
    }

    public function removeUserKpi(UserKpi $userKpi): self
    {
        if (true === $this->userKpis->contains($userKpi)) {
            $this->userKpis->removeElement($userKpi);
        }

        return $this;
    }

    public function getUsername(): string
    {
        return (string) $this->email;
    }

    public function addUserQuestionnaire(UserQuestionnaire $userQuestionnaire): self
    {
        if (false === $this->userQuestionnaires->contains($userQuestionnaire)) {
            $this->userQuestionnaires->add($userQuestionnaire);
            $userQuestionnaire->setUser($this);
        }

        return $this;
    }

    public function getUserQuestionnaires(): Collection
    {
        return $this->userQuestionnaires->filter(function (UserQuestionnaire $userQuestionnaire) {
            return null === $userQuestionnaire->getDeletedAt();
        });
    }

    public function getUserQuestionnairesAll(): Collection
    {
        return $this->userQuestionnaires;
    }

    public function removeUserQuestionnaire(UserQuestionnaire $userQuestionnaire): self
    {
        if (true === $this->userQuestionnaires->contains($userQuestionnaire)) {
            $this->userQuestionnaires->removeElement($userQuestionnaire);
        }

        return $this;
    }
}
