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

    public const THEME_DARK = 'dark';
    public const THEME_LIGHT = 'light';

    /**
     * @Assert\Valid
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\OneToOne(fetch="EXTRA_LAZY", inversedBy="profile", targetEntity=User::class)
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

    /**
     * @Assert\NotNull
     * @Assert\Type("bool")
     * @ORM\Column(type="boolean")
     */
    private bool $showMotivationalMessages;

    /**
     * @Assert\Choice(callback="getThemeValidationChoices")
     * @Assert\Length(
     *   max = 8
     * )
     * @Assert\Type("string")
     * @ORM\Column(length=8, nullable=true, type="string")
     */
    private ?string $theme;

    /**
     * @Assert\Length(
     *   max = 36
     * )
     * @Assert\Timezone
     * @Assert\Type("string")
     * @ORM\Column(length=36, nullable=true, type="string")
     */
    private ?string $timeZone;

    public function __construct()
    {
        $this->phone = null;
        $this->showMotivationalMessages = true;
        $this->theme = self::THEME_DARK;
    }

    public function __toString(): string
    {
        return $this->getUuid();
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getPhone(): ?PhoneNumber
    {
        return $this->phone;
    }

    public function setPhone(?PhoneNumber $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getShowMotivationalMessages(): ?bool
    {
        return $this->showMotivationalMessages;
    }

    public function setShowMotivationalMessages(bool $showMotivationalMessages): self
    {
        $this->showMotivationalMessages = $showMotivationalMessages;

        return $this;
    }

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public static function getThemeFormChoices(): array
    {
        return [
            self::THEME_DARK => self::THEME_DARK,
            //self::THEME_LIGHT => self::THEME_LIGHT,
        ];
    }

    public function getThemeValidationChoices(): array
    {
        return array_keys(self::getThemeFormChoices());
    }

    public function setTheme(?string $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    public function getTimeZone(): ?string
    {
        return $this->timeZone;
    }

    public function setTimeZone(?string $timeZone): self
    {
        $this->timeZone = $timeZone;

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
