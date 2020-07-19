<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProfileRepository::class)
 */
class Profile
{
    use Traits\IdTrait;
    use Traits\UuidTrait;
    use Traits\BlameableTrait;
    use Traits\TimestampableTrait;

    /**
     * @ORM\JoinColumn(name="user_id", nullable=false, onDelete="CASCADE", referencedColumnName="id")
     * @ORM\OneToOne(fetch="EXTRA_LAZY", inversedBy="profile", targetEntity="User")
     */
    private $user;

    public function __toString(): string
    {
        return $this->getUuid();
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
