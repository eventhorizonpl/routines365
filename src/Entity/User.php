<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    use Traits\IdTrait;
    use Traits\UuidTrait;
    use Traits\BlameableTrait;
    use Traits\TimestampableTrait;

    /**
     * @ORM\OneToOne(targetEntity="Profile", mappedBy="user")
     */
    private $profile;

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
     * @Assert\NotBlank
     * @Assert\Type("bool")
     * @ORM\Column(type="boolean")
     */
    private bool $isEnabled = false;

    /**
     * @Assert\Length(
     *   max = 255
     * )
     * @Assert\NotBlank
     * @Assert\NotCompromisedPassword
     * @Assert\Type("string")
     * @ORM\Column(type="string")
     */
    private string $password;

    /**
     * @Assert\NotBlank
     * @Assert\Type("array")
     * @ORM\Column(type="json")
     */
    private array $roles = [];

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

    public function getIsEnabled(): ?bool
    {
        return $this->isEnabled;
    }

    public function setIsEnabled(bool $isEnabled): self
    {
        $this->isEnabled = $isEnabled;

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
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
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
}
