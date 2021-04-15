<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\{Profile, User};
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use InvalidArgumentException;
use libphonenumber\PhoneNumberUtil;
use Symfony\Component\Uid\Uuid;

/**
 * @internal
 */
final class ProfileTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile);
    }

    public function testToString(): void
    {
        $uuid = (string) Uuid::v4();
        $profile = new Profile();
        $profile->setUuid($uuid);
        $this->assertSame($uuid, $profile->__toString());
    }

    public function testGetId(): void
    {
        $profile = new Profile();
        $this->assertNull($profile->getId());
    }

    public function testGetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $profile = new Profile();
        $this->assertNull($profile->getUuid());
        $profile->setUuid($uuid);
        $this->assertSame($uuid, $profile->getUuid());
        $this->assertIsString($profile->getUuid());
    }

    public function testSetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setUuid($uuid));
        $this->assertSame($uuid, $profile->getUuid());
    }

    public function testGetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $profile = new Profile();
        $this->assertNull($profile->getCreatedBy());
        $profile->setCreatedBy($createdBy);
        $this->assertSame($createdBy, $profile->getCreatedBy());
        $this->assertIsString($profile->getCreatedBy());
    }

    public function testSetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setCreatedBy($createdBy));
        $this->assertSame($createdBy, $profile->getCreatedBy());
    }

    public function testGetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $profile = new Profile();
        $this->assertNull($profile->getDeletedBy());
        $profile->setDeletedBy($deletedBy);
        $this->assertSame($deletedBy, $profile->getDeletedBy());
        $this->assertIsString($profile->getDeletedBy());
    }

    public function testSetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setDeletedBy($deletedBy));
        $this->assertSame($deletedBy, $profile->getDeletedBy());
    }

    public function testGetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $profile = new Profile();
        $this->assertNull($profile->getUpdatedBy());
        $profile->setUpdatedBy($updatedBy);
        $this->assertSame($updatedBy, $profile->getUpdatedBy());
        $this->assertIsString($profile->getUpdatedBy());
    }

    public function testSetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setUpdatedBy($updatedBy));
        $this->assertSame($updatedBy, $profile->getUpdatedBy());
    }

    public function testGetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $profile = new Profile();
        $this->assertNull($profile->getCreatedAt());
        $profile->setCreatedAt($createdAt);
        $this->assertSame($createdAt, $profile->getCreatedAt());
    }

    public function testSetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setCreatedAt($createdAt));
        $this->assertSame($createdAt, $profile->getCreatedAt());
    }

    public function testGetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $profile = new Profile();
        $this->assertNull($profile->getDeletedAt());
        $profile->setDeletedAt($deletedAt);
        $this->assertSame($deletedAt, $profile->getDeletedAt());
    }

    public function testSetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setDeletedAt($deletedAt));
        $this->assertSame($deletedAt, $profile->getDeletedAt());
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $profile = new Profile();
        $this->assertNull($profile->getUpdatedAt());
        $profile->setUpdatedAt($updatedAt);
        $this->assertSame($updatedAt, $profile->getUpdatedAt());
    }

    public function testSetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setUpdatedAt($updatedAt));
        $this->assertSame($updatedAt, $profile->getUpdatedAt());
    }

    public function testGetIsVerified(): void
    {
        $isVerified = true;
        $profile = new Profile();
        $this->assertFalse($profile->getIsVerified());
        $profile->setIsVerified($isVerified);
        $this->assertSame($isVerified, $profile->getIsVerified());
        $this->assertIsBool($profile->getIsVerified());
    }

    public function testSetIsVerified(): void
    {
        $isVerified = true;
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setIsVerified($isVerified));
        $this->assertSame($isVerified, $profile->getIsVerified());
    }

    public function testGetUser(): void
    {
        $user = new User();
        $profile = new Profile();
        $profile->setUser($user);
        $this->assertSame($user, $profile->getUser());
    }

    public function testSetUser(): void
    {
        $user = new User();
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setUser($user));
        $this->assertSame($user, $profile->getUser());
    }

    public function testGetCountry(): void
    {
        $country = 'pl';
        $profile = new Profile();
        $profile->setCountry($country);
        $this->assertSame($country, $profile->getCountry());
        $this->assertIsString($profile->getCountry());
    }

    public function testSetCountry(): void
    {
        $country = 'pl';
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setCountry($country));
        $this->assertSame($country, $profile->getCountry());
    }

    public function testGetFirstName(): void
    {
        $firstName = 'test first name';
        $profile = new Profile();
        $this->assertNull($profile->getFirstName());
        $profile->setFirstName($firstName);
        $this->assertSame($firstName, $profile->getFirstName());
        $this->assertIsString($profile->getFirstName());
    }

    public function testSetFirstName(): void
    {
        $firstName = 'test first name';
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setFirstName($firstName));
        $this->assertSame($firstName, $profile->getFirstName());
    }

    public function testGetLastName(): void
    {
        $lastName = 'test last name';
        $profile = new Profile();
        $this->assertNull($profile->getLastName());
        $profile->setLastName($lastName);
        $this->assertSame($lastName, $profile->getLastName());
        $this->assertIsString($profile->getLastName());
    }

    public function testSetLastName(): void
    {
        $lastName = 'test last name';
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setLastName($lastName));
        $this->assertSame($lastName, $profile->getLastName());
    }

    public function testGetNumberOfPhoneVerificationTries(): void
    {
        $numberOfPhoneVerificationTries = 10;
        $profile = new Profile();
        $this->assertNull($profile->getNumberOfPhoneVerificationTries());
        $profile->setNumberOfPhoneVerificationTries($numberOfPhoneVerificationTries);
        $this->assertSame($numberOfPhoneVerificationTries, $profile->getNumberOfPhoneVerificationTries());
        $this->assertIsInt($profile->getNumberOfPhoneVerificationTries());
    }

    public function testIncrementNumberOfPhoneVerificationTries(): void
    {
        $profile = new Profile();
        $this->assertNull($profile->getNumberOfPhoneVerificationTries());
        $this->assertInstanceOf(Profile::class, $profile->incrementNumberOfPhoneVerificationTries());
        $this->assertSame(1, $profile->getNumberOfPhoneVerificationTries());
    }

    public function testSetNumberOfPhoneVerificationTries(): void
    {
        $numberOfPhoneVerificationTries = 10;
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setNumberOfPhoneVerificationTries($numberOfPhoneVerificationTries));
        $this->assertSame($numberOfPhoneVerificationTries, $profile->getNumberOfPhoneVerificationTries());
    }

    public function testGetPhone(): void
    {
        $phoneNumberUtil = PhoneNumberUtil::getInstance();
        $phone = $phoneNumberUtil->parse('+48881573056');
        $profile = new Profile();
        $this->assertNull($profile->getPhone());
        $profile->setPhone($phone);
        $this->assertSame($phone, $profile->getPhone());
    }

    public function testGetPhoneString(): void
    {
        $phoneNumberUtil = PhoneNumberUtil::getInstance();
        $phoneString = '+48 881 573 056';
        $phone = $phoneNumberUtil->parse($phoneString);
        $profile = new Profile();
        $this->assertNull($profile->getPhoneString());
        $profile->setPhone($phone);
        $this->assertSame($phoneString, $profile->getPhoneString());
    }

    public function testSetPhone(): void
    {
        $phoneNumberUtil = PhoneNumberUtil::getInstance();
        $phone = $phoneNumberUtil->parse('+48881573056');
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setPhone($phone));
        $this->assertSame($phone, $profile->getPhone());
    }

    public function testGetPhoneMd5(): void
    {
        $phoneMd5 = md5('test phone md5');
        $profile = new Profile();
        $this->assertNull($profile->getPhoneMd5());
        $profile->setPhoneMd5($phoneMd5);
        $this->assertSame($phoneMd5, $profile->getPhoneMd5());
        $this->assertIsString($profile->getPhoneMd5());
    }

    public function testSetPhoneMd5(): void
    {
        $phoneMd5 = md5('test phone md5');
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setPhoneMd5($phoneMd5));
        $this->assertSame($phoneMd5, $profile->getPhoneMd5());
    }

    public function testGetPhoneVerificationCode(): void
    {
        $phoneVerificationCode = 10;
        $profile = new Profile();
        $profile->setPhoneVerificationCode($phoneVerificationCode);
        $this->assertSame($phoneVerificationCode, $profile->getPhoneVerificationCode());
        $this->assertIsInt($profile->getPhoneVerificationCode());
    }

    public function testSetPhoneVerificationCode(): void
    {
        $phoneVerificationCode = 10;
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setPhoneVerificationCode($phoneVerificationCode));
        $this->assertSame($phoneVerificationCode, $profile->getPhoneVerificationCode());
    }

    public function testGetProfileCompletenessPercent(): void
    {
        $country = 'pl';
        $firstName = 'test first name';
        $isVerified = true;
        $lastName = 'test last name';
        $phoneNumberUtil = PhoneNumberUtil::getInstance();
        $phone = $phoneNumberUtil->parse('+48881573056');
        $showMotivationalMessages = true;
        $theme = Profile::THEME_DARK;
        $timeZone = 'test time zone';
        $email = 'test email';
        $user = new User();
        $user->setEmail($email);
        $user->setIsVerified($isVerified);
        $profile = new Profile();
        $profile->setCountry($country);
        $profile->setFirstName($firstName);
        $profile->setIsVerified($isVerified);
        $profile->setLastName($lastName);
        $profile->setPhone($phone);
        $profile->setShowMotivationalMessages($showMotivationalMessages);
        $profile->setTheme($theme);
        $profile->setTimeZone($timeZone);
        $profile->setUser($user);
        $this->assertSame(100, $profile->getProfileCompletenessPercent());
        $this->assertIsInt($profile->getProfileCompletenessPercent());
    }

    public function testGetSendWeeklyMonthlyStatistics(): void
    {
        $sendWeeklyMonthlyStatistics = true;
        $profile = new Profile();
        $this->assertTrue($profile->getSendWeeklyMonthlyStatistics());
        $profile->setSendWeeklyMonthlyStatistics($sendWeeklyMonthlyStatistics);
        $this->assertSame($sendWeeklyMonthlyStatistics, $profile->getSendWeeklyMonthlyStatistics());
        $this->assertIsBool($profile->getSendWeeklyMonthlyStatistics());
    }

    public function testSetSendWeeklyMonthlyStatistics(): void
    {
        $sendWeeklyMonthlyStatistics = true;
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setSendWeeklyMonthlyStatistics($sendWeeklyMonthlyStatistics));
        $this->assertSame($sendWeeklyMonthlyStatistics, $profile->getSendWeeklyMonthlyStatistics());
    }

    public function testGetShowMotivationalMessages(): void
    {
        $showMotivationalMessages = true;
        $profile = new Profile();
        $this->assertTrue($profile->getShowMotivationalMessages());
        $profile->setShowMotivationalMessages($showMotivationalMessages);
        $this->assertSame($showMotivationalMessages, $profile->getShowMotivationalMessages());
        $this->assertIsBool($profile->getShowMotivationalMessages());
    }

    public function testSetShowMotivationalMessages(): void
    {
        $showMotivationalMessages = true;
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setShowMotivationalMessages($showMotivationalMessages));
        $this->assertSame($showMotivationalMessages, $profile->getShowMotivationalMessages());
    }

    public function testGetTheme(): void
    {
        $theme = Profile::THEME_DARK;
        $profile = new Profile();
        $profile->setTheme($theme);
        $this->assertSame($theme, $profile->getTheme());
        $this->assertIsString($profile->getTheme());
    }

    public function testGetThemeFormChoices(): void
    {
        $this->assertCount(2, Profile::getThemeFormChoices());
        $this->assertIsArray(Profile::getThemeFormChoices());
    }

    public function testGetThemeValidationChoices(): void
    {
        $this->assertCount(2, Profile::getThemeValidationChoices());
        $this->assertIsArray(Profile::getThemeValidationChoices());
    }

    public function testSetTheme(): void
    {
        $theme = Profile::THEME_DARK;
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setTheme($theme));
        $this->assertSame($theme, $profile->getTheme());
    }

    public function testSetThemeException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $theme = 'wrong theme';
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setTheme($theme));
    }

    public function testGetTimeZone(): void
    {
        $timeZone = 'test time zone';
        $profile = new Profile();
        $this->assertNull($profile->getTimeZone());
        $profile->setTimeZone($timeZone);
        $this->assertSame($timeZone, $profile->getTimeZone());
        $this->assertIsString($profile->getTimeZone());
    }

    public function testSetTimeZone(): void
    {
        $timeZone = 'test time zone';
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setTimeZone($timeZone));
        $this->assertSame($timeZone, $profile->getTimeZone());
    }
}
