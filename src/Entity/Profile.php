<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\ORM\Mapping as ORM;
use libphonenumber\PhoneNumber;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\Valid
     * @ORM\JoinColumn(name="user_id", nullable=false, onDelete="CASCADE", referencedColumnName="id")
     * @ORM\OneToOne(fetch="EXTRA_LAZY", inversedBy="profile", targetEntity="User")
     */
    private User $user;

    /**
     * @Assert\Length(
     *   max = 2
     * )
     * @Assert\Type("string")
     * @ORM\Column(length=2, nullable=true, type="string")
     */
    private ?string $country;

    /**
     * @AssertPhoneNumber(type="mobile")
     * @ORM\Column(nullable=true, type="phone_number", unique=true)
     */
    private ?PhoneNumber $phone;

    public function __construct()
    {
        $this->phone = null;
    }

    public function __toString(): string
    {
        return $this->getUuid();
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getPhone(): ?PhoneNumber
    {
        return $this->phone;
    }

    public function setPhone(PhoneNumber $phone): self
    {
        $this->phone = $phone;

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
