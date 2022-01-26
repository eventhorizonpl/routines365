<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\ProfileThemeEnum;
use App\Repository\ProfileRepository;
use App\Resource\ConfigResource;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use libphonenumber\{PhoneNumber, PhoneNumberFormat, PhoneNumberUtil};
use Misd\PhoneNumberBundle\Doctrine\DBAL\Types\PhoneNumberType;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProfileRepository::class)]
class Profile
{
    use Traits\BlameableTrait;
    use Traits\IdTrait;
    use Traits\IsVerifiedTrait;
    use Traits\TimestampableTrait;
    use Traits\UuidTrait;

    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[ORM\OneToOne(fetch: 'EXTRA_LAZY', inversedBy: 'profile', targetEntity: User::class)]
    private User $user;

    #[Assert\Length(max: 2)]
    #[Assert\Type('string')]
    #[ORM\Column(length: 2, nullable: true, type: Types::STRING)]
    private ?string $country;

    #[Assert\Length(max: 64)]
    #[Assert\Type('string')]
    #[Groups(['gdpr'])]
    #[ORM\Column(length: 64, nullable: true, type: Types::STRING)]
    private ?string $firstName;

    #[Assert\Length(max: 64)]
    #[Assert\Type('string')]
    #[Groups(['gdpr'])]
    #[ORM\Column(length: 64, nullable: true, type: Types::STRING)]
    private ?string $lastName;

    #[Assert\GreaterThanOrEqual(0)]
    #[Assert\LessThanOrEqual(5)]
    #[Assert\Type('int')]
    #[ORM\Column(nullable: true, type: Types::INTEGER)]
    private ?int $numberOfPhoneVerificationTries;

    #[AssertPhoneNumber(type: 'mobile')]
    #[Groups(['gdpr'])]
    #[ORM\Column(nullable: true, type: PhoneNumberType::NAME, unique: true)]
    private ?PhoneNumber $phone;

    #[Assert\Length(max: 32)]
    #[Assert\Type('string')]
    #[ORM\Column(length: 32, nullable: true, type: Types::STRING, unique: true)]
    private ?string $phoneMd5;

    #[Assert\GreaterThanOrEqual(100000)]
    #[Assert\LessThanOrEqual(999999)]
    #[Assert\Type('int')]
    #[ORM\Column(nullable: true, type: Types::INTEGER)]
    private ?int $phoneVerificationCode;

    #[Assert\Type('bool')]
    #[Groups(['gdpr'])]
    #[ORM\Column(type: Types::BOOLEAN)]
    private ?bool $sendWeeklyMonthlyStatistics;

    #[Assert\NotNull]
    #[Assert\Type('bool')]
    #[Groups(['gdpr'])]
    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $showMotivationalMessages;

    #[Assert\Choice(callback: 'getThemeValidationChoices')]
    #[Assert\Type(ProfileThemeEnum::class)]
    #[Groups(['gdpr'])]
    #[ORM\Column(enumType: ProfileThemeEnum::class, length: 8, nullable: true, type: Types::STRING)]
    private ?ProfileThemeEnum $theme;

    #[Assert\Length(max: 36)]
    #[Assert\Timezone]
    #[Assert\Type('string')]
    #[Groups(['gdpr'])]
    #[ORM\Column(length: 36, nullable: true, type: Types::STRING)]
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
        $this->sendWeeklyMonthlyStatistics = true;
        $this->showMotivationalMessages = true;
        $this->theme = ProfileThemeEnum::DARK;
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

            return $phoneNumberUtil->format($this->getPhone(), PhoneNumberFormat::INTERNATIONAL);
        }

        return null;
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

    public function getSendWeeklyMonthlyStatistics(): ?bool
    {
        return $this->sendWeeklyMonthlyStatistics;
    }

    public function setSendWeeklyMonthlyStatistics(bool $sendWeeklyMonthlyStatistics): self
    {
        $this->sendWeeklyMonthlyStatistics = $sendWeeklyMonthlyStatistics;

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

    public function getTheme(): ?ProfileThemeEnum
    {
        return $this->theme;
    }

    public static function getThemeFormChoices(): array
    {
        return [
            ProfileThemeEnum::DARK->value => ProfileThemeEnum::DARK->value,
            ProfileThemeEnum::LIGHT->value => ProfileThemeEnum::LIGHT->value,
        ];
    }

    public static function getThemeValidationChoices(): array
    {
        return [
            ProfileThemeEnum::DARK,
            ProfileThemeEnum::LIGHT,
        ];
    }

    public function setTheme(?ProfileThemeEnum $theme): self
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
