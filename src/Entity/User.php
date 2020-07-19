<?php

namespace App\Entity;

use App\Repository\UserRepository;
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
     * @ORM\OneToOne(fetch="EXTRA_LAZY", targetEntity="Profile", mappedBy="user")
     */
    private Profile $profile;

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
        $this->isEnabled = false;
        $this->isVerified = false;
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
