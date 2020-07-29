<?php

namespace App\Entity;

use App\Repository\AccountRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AccountRepository::class)
 */
class Account
{
    use Traits\IdTrait;
    use Traits\UuidTrait;
    use Traits\BlameableTrait;
    use Traits\TimestampableTrait;

    /**
     * @Assert\Valid
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\OneToOne(fetch="EXTRA_LAZY", inversedBy="account", targetEntity=User::class)
     */
    private User $user;

    /**
     * @Assert\NotBlank
     * @Assert\Type("int")
     * @ORM\Column(type="integer")
     */
    private int $availableEmailNotifications;

    /**
     * @Assert\NotBlank
     * @Assert\Type("int")
     * @ORM\Column(type="integer")
     */
    private int $availableSmsNotifications;

    public function __construct()
    {
        $this->availableEmailNotifications = 0;
        $this->availableSmsNotifications = 0;
    }

    public function __toString(): string
    {
        return $this->getUuid();
    }

    public function getAvailableEmailNotifications(): int
    {
        return $this->availableEmailNotifications;
    }

    public function setAvailableEmailNotifications(int $availableEmailNotifications): self
    {
        $this->availableEmailNotifications = $availableEmailNotifications;

        return $this;
    }

    public function getAvailableSmsNotifications(): int
    {
        return $this->availableSmsNotifications;
    }

    public function setAvailableSmsNotifications(int $availableSmsNotifications): self
    {
        $this->availableSmsNotifications = $availableSmsNotifications;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
