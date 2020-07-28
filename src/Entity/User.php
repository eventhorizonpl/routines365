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
     * @ORM\OneToMany(fetch="EXTRA_LAZY", mappedBy="user", orphanRemoval=true, targetEntity=Reminder::class)
     */
    private Collection $reminders;

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
     * @Assert\Choice(callback="getRolesFormChoices", multiple=true)
     * @Assert\NotNull
     * @Assert\Type("array")
     * @ORM\Column(type="json")
     */
    private array $roles = [];

    /**
     * @Assert\NotNull
     * @Assert\Type("bool")
     * @ORM\Column(type="boolean")
     */
    private bool $isVerified;

    public function __construct()
    {
        $this->email = '';
        $this->goals = new ArrayCollection();
        $this->isEnabled = false;
        $this->isVerified = false;
        $this->notes = new ArrayCollection();
        $this->reminders = new ArrayCollection();
        $this->routines = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getUuid();
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
            return (null === $goal->getDeletedAt());
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
            return (null === $note->getDeletedAt());
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
            return (null === $reminder->getDeletedAt());
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

    public function getRolesValidationChoices(): array
    {
        return [
            self::ROLE_ADMIN,
            self::ROLE_SUPER_ADMIN,
            self::ROLE_USER,
        ];
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
            return (null === $routine->getDeletedAt());
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

    public function getUsername(): string
    {
        return (string) $this->email;
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
}
