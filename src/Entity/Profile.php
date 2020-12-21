<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProfileRepository;
use App\Resource\ConfigResource;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProfileRepository::class)
 */
class Profile
{
    use Traits\IdTrait;
    use Traits\UuidTrait;
    use Traits\IsVerifiedTrait;
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
     * @Assert\Length(
     *   max = 64
     * )
     * @Assert\Type("string")
     * @ORM\Column(length=64, nullable=true, type="string")
     */
    private ?string $firstName;

    /**
     * @Assert\Length(
     *   max = 64
     * )
     * @Assert\Type("string")
     * @ORM\Column(length=64, nullable=true, type="string")
     */
    private ?string $lastName;

    /**
     * @Assert\GreaterThanOrEqual(0)
     * @Assert\LessThanOrEqual(5)
     * @Assert\Type("int")
     * @ORM\Column(nullable=true, type="integer")
     */
    private ?int $numberOfPhoneVerificationTries;

    /**
     * @AssertPhoneNumber(type="mobile")
     * @ORM\Column(nullable=true, type="phone_number", unique=true)
     */
    private ?PhoneNumber $phone;

    /**
     * @Assert\Length(
     *   max = 32
     * )
     * @Assert\Type("string")
     * @ORM\Column(nullable=true, length=32, type="string", unique=true)
     */
    private ?string $phoneMd5;

    /**
     * @Assert\GreaterThanOrEqual(100000)
     * @Assert\LessThanOrEqual(999999)
     * @Assert\Type("int")
     * @ORM\Column(nullable=true, type="integer")
     */
    private ?int $phoneVerificationCode;

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
        $this->country = null;
        $this->firstName = null;
        $this->isVerified = false;
        $this->lastName = null;
        $this->numberOfPhoneVerificationTries = null;
        $this->phone = null;
        $this->phoneMd5 = null;
        $this->showMotivationalMessages = true;
        $this->theme = self::THEME_DARK;
        $this->timeZone = null;
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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getNumberOfPhoneVerificationTries(): ?int
    {
        return $this->numberOfPhoneVerificationTries;
    }

    public function incrementNumberOfPhoneVerificationTries(): self
    {
        $this->setNumberOfPhoneVerificationTries($this->getNumberOfPhoneVerificationTries() + 1);

        return $this;
    }

    public function setNumberOfPhoneVerificationTries(?int $numberOfPhoneVerificationTries): self
    {
        $this->numberOfPhoneVerificationTries = $numberOfPhoneVerificationTries;

        return $this;
    }

    public function getPhone(): ?PhoneNumber
    {
        return $this->phone;
    }

    public function getPhoneString(): ?string
    {
        if (null !== $this->getPhone()) {
            $phoneNumberUtil = PhoneNumberUtil::getInstance();
            $phone = $phoneNumberUtil->format($this->getPhone(), PhoneNumberFormat::INTERNATIONAL);

            return $phone;
        } else {
            return null;
        }
    }

    public function setPhone(?PhoneNumber $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPhoneMd5(): ?string
    {
        return $this->phoneMd5;
    }

    public function setPhoneMd5(?string $phoneMd5): self
    {
        $this->phoneMd5 = $phoneMd5;

        return $this;
    }

    public function getPhoneVerificationCode(): ?int
    {
        return $this->phoneVerificationCode;
    }

    public function setPhoneVerificationCode(?int $phoneVerificationCode): self
    {
        $this->phoneVerificationCode = $phoneVerificationCode;

        return $this;
    }

    public function getProfileCompletenessPercent(): int
    {
        $itemsCompleted = 0;
        $itemsToComplete = 8;

        if (null !== $this->getCountry()) {
            ++$itemsCompleted;
        }

        if (true === ConfigResource::INVITATIONS_ENABLED) {
            if (null !== $this->getFirstName()) {
                ++$itemsCompleted;
            }

            if (null !== $this->getLastName()) {
                ++$itemsCompleted;
            }

            $itemsToComplete += 2;
        }

        if (null !== $this->getPhone()) {
            ++$itemsCompleted;
        }

        if (true === $this->getIsVerified()) {
            ++$itemsCompleted;
        }

        if (null !== $this->getShowMotivationalMessages()) {
            ++$itemsCompleted;
        }

        if (null !== $this->getTheme()) {
            ++$itemsCompleted;
        }

        if (null !== $this->getTimeZone()) {
            ++$itemsCompleted;
        }

        if (null !== $this->getUser()->getEmail()) {
            ++$itemsCompleted;
        }

        if (true === $this->getUser()->getIsVerified()) {
            ++$itemsCompleted;
        }

        return (int) (($itemsCompleted / $itemsToComplete) * 100);
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

    public static function getThemeValidationChoices(): array
    {
        return array_keys(self::getThemeFormChoices());
    }

    public function setTheme(?string $theme): self
    {
        if (!(in_array($theme, self::getThemeValidationChoices()))) {
            throw new InvalidArgumentException('Invalid theme');
        }

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
