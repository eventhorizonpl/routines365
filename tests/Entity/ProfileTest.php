<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Profile;
use App\Entity\User;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use libphonenumber\PhoneNumberUtil;
use Symfony\Component\Uid\Uuid;

class ProfileTest extends AbstractTestCase
{
    public function testConstruct()
    {
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile);
    }

    public function testToString()
    {
        $uuid = (string) Uuid::v4();
        $profile = new Profile();
        $profile->setUuid($uuid);
        $this->assertEquals($uuid, $profile->__toString());
    }

    public function testGetId()
    {
        $profile = new Profile();
        $this->assertEquals(null, $profile->getId());
    }

    public function testGetUuid()
    {
        $uuid = (string) Uuid::v4();
        $profile = new Profile();
        $this->assertEquals(null, $profile->getUuid());
        $profile->setUuid($uuid);
        $this->assertEquals($uuid, $profile->getUuid());
        $this->assertIsString($profile->getUuid());
    }

    public function testSetUuid()
    {
        $uuid = (string) Uuid::v4();
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setUuid($uuid));
        $this->assertEquals($uuid, $profile->getUuid());
    }

    public function testGetCreatedBy()
    {
        $createdBy = (string) Uuid::v4();
        $profile = new Profile();
        $this->assertEquals(null, $profile->getCreatedBy());
        $profile->setCreatedBy($createdBy);
        $this->assertEquals($createdBy, $profile->getCreatedBy());
        $this->assertIsString($profile->getCreatedBy());
    }

    public function testSetCreatedBy()
    {
        $createdBy = (string) Uuid::v4();
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setCreatedBy($createdBy));
        $this->assertEquals($createdBy, $profile->getCreatedBy());
    }

    public function testGetDeletedBy()
    {
        $deletedBy = (string) Uuid::v4();
        $profile = new Profile();
        $this->assertEquals(null, $profile->getDeletedBy());
        $profile->setDeletedBy($deletedBy);
        $this->assertEquals($deletedBy, $profile->getDeletedBy());
        $this->assertIsString($profile->getDeletedBy());
    }

    public function testSetDeletedBy()
    {
        $deletedBy = (string) Uuid::v4();
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setDeletedBy($deletedBy));
        $this->assertEquals($deletedBy, $profile->getDeletedBy());
    }

    public function testGetUpdatedBy()
    {
        $updatedBy = (string) Uuid::v4();
        $profile = new Profile();
        $this->assertEquals(null, $profile->getUpdatedBy());
        $profile->setUpdatedBy($updatedBy);
        $this->assertEquals($updatedBy, $profile->getUpdatedBy());
        $this->assertIsString($profile->getUpdatedBy());
    }

    public function testSetUpdatedBy()
    {
        $updatedBy = (string) Uuid::v4();
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setUpdatedBy($updatedBy));
        $this->assertEquals($updatedBy, $profile->getUpdatedBy());
    }

    public function testGetCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $profile = new Profile();
        $this->assertEquals(null, $profile->getCreatedAt());
        $profile->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $profile->getCreatedAt());
    }

    public function testSetCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setCreatedAt($createdAt));
        $this->assertEquals($createdAt, $profile->getCreatedAt());
    }

    public function testGetDeletedAt()
    {
        $deletedAt = new DateTimeImmutable();
        $profile = new Profile();
        $this->assertEquals(null, $profile->getDeletedAt());
        $profile->setDeletedAt($deletedAt);
        $this->assertEquals($deletedAt, $profile->getDeletedAt());
    }

    public function testSetDeletedAt()
    {
        $deletedAt = new DateTimeImmutable();
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setDeletedAt($deletedAt));
        $this->assertEquals($deletedAt, $profile->getDeletedAt());
    }

    public function testGetUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $profile = new Profile();
        $this->assertEquals(null, $profile->getUpdatedAt());
        $profile->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $profile->getUpdatedAt());
    }

    public function testSetUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setUpdatedAt($updatedAt));
        $this->assertEquals($updatedAt, $profile->getUpdatedAt());
    }

    public function testGetIsVerified()
    {
        $isVerified = true;
        $profile = new Profile();
        $this->assertEquals(null, $profile->getIsVerified());
        $profile->setIsVerified($isVerified);
        $this->assertEquals($isVerified, $profile->getIsVerified());
        $this->assertIsBool($profile->getIsVerified());
    }

    public function testSetIsVerified()
    {
        $isVerified = true;
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setIsVerified($isVerified));
        $this->assertEquals($isVerified, $profile->getIsVerified());
    }

    public function testGetUser()
    {
        $user = new User();
        $profile = new Profile();
        $profile->setUser($user);
        $this->assertEquals($user, $profile->getUser());
    }

    public function testSetUser()
    {
        $user = new User();
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setUser($user));
        $this->assertEquals($user, $profile->getUser());
    }

    public function testGetCountry()
    {
        $country = 'pl';
        $profile = new Profile();
        $profile->setCountry($country);
        $this->assertEquals($country, $profile->getCountry());
        $this->assertIsString($profile->getCountry());
    }

    public function testSetCountry()
    {
        $country = 'pl';
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setCountry($country));
        $this->assertEquals($country, $profile->getCountry());
    }

    public function testGetFirstName()
    {
        $firstName = 'test first name';
        $profile = new Profile();
        $this->assertEquals(null, $profile->getFirstName());
        $profile->setFirstName($firstName);
        $this->assertEquals($firstName, $profile->getFirstName());
        $this->assertIsString($profile->getFirstName());
    }

    public function testSetFirstName()
    {
        $firstName = 'test first name';
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setFirstName($firstName));
        $this->assertEquals($firstName, $profile->getFirstName());
    }

    public function testGetLastName()
    {
        $lastName = 'test last name';
        $profile = new Profile();
        $this->assertEquals(null, $profile->getLastName());
        $profile->setLastName($lastName);
        $this->assertEquals($lastName, $profile->getLastName());
        $this->assertIsString($profile->getLastName());
    }

    public function testSetLastName()
    {
        $lastName = 'test last name';
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setLastName($lastName));
        $this->assertEquals($lastName, $profile->getLastName());
    }

    public function testGetNumberOfPhoneVerificationTries()
    {
        $numberOfPhoneVerificationTries = 10;
        $profile = new Profile();
        $this->assertEquals(0, $profile->getNumberOfPhoneVerificationTries());
        $profile->setNumberOfPhoneVerificationTries($numberOfPhoneVerificationTries);
        $this->assertEquals($numberOfPhoneVerificationTries, $profile->getNumberOfPhoneVerificationTries());
        $this->assertIsInt($profile->getNumberOfPhoneVerificationTries());
    }

    public function testIncrementNumberOfPhoneVerificationTries()
    {
        $profile = new Profile();
        $this->assertEquals(0, $profile->getNumberOfPhoneVerificationTries());
        $this->assertInstanceOf(Profile::class, $profile->incrementNumberOfPhoneVerificationTries());
        $this->assertEquals(1, $profile->getNumberOfPhoneVerificationTries());
    }

    public function testSetNumberOfPhoneVerificationTries()
    {
        $numberOfPhoneVerificationTries = 10;
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setNumberOfPhoneVerificationTries($numberOfPhoneVerificationTries));
        $this->assertEquals($numberOfPhoneVerificationTries, $profile->getNumberOfPhoneVerificationTries());
    }

    public function testGetPhone()
    {
        $phoneNumberUtil = PhoneNumberUtil::getInstance();
        $phone = $phoneNumberUtil->parse('+48881573056');
        $profile = new Profile();
        $this->assertEquals(null, $profile->getPhone());
        $profile->setPhone($phone);
        $this->assertEquals($phone, $profile->getPhone());
    }

    public function testGetPhoneString()
    {
        $phoneNumberUtil = PhoneNumberUtil::getInstance();
        $phoneString = '+48 881 573 056';
        $phone = $phoneNumberUtil->parse($phoneString);
        $profile = new Profile();
        $profile->setPhone($phone);
        $this->assertEquals($phoneString, $profile->getPhoneString());
    }

    public function testSetPhone()
    {
        $phoneNumberUtil = PhoneNumberUtil::getInstance();
        $phone = $phoneNumberUtil->parse('+48881573056');
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setPhone($phone));
        $this->assertEquals($phone, $profile->getPhone());
    }

    public function testGetPhoneMd5()
    {
        $phoneMd5 = md5('test phone md5');
        $profile = new Profile();
        $this->assertEquals(null, $profile->getPhoneMd5());
        $profile->setPhoneMd5($phoneMd5);
        $this->assertEquals($phoneMd5, $profile->getPhoneMd5());
        $this->assertIsString($profile->getPhoneMd5());
    }

    public function testSetPhoneMd5()
    {
        $phoneMd5 = md5('test phone md5');
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setPhoneMd5($phoneMd5));
        $this->assertEquals($phoneMd5, $profile->getPhoneMd5());
    }

    public function testGetPhoneVerificationCode()
    {
        $phoneVerificationCode = 10;
        $profile = new Profile();
        $profile->setPhoneVerificationCode($phoneVerificationCode);
        $this->assertEquals($phoneVerificationCode, $profile->getPhoneVerificationCode());
        $this->assertIsInt($profile->getPhoneVerificationCode());
    }

    public function testSetPhoneVerificationCode()
    {
        $phoneVerificationCode = 10;
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setPhoneVerificationCode($phoneVerificationCode));
        $this->assertEquals($phoneVerificationCode, $profile->getPhoneVerificationCode());
    }

    public function testGetProfileCompletenessPercent()
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
        $this->assertEquals(100, $profile->getProfileCompletenessPercent());
        $this->assertIsInt($profile->getProfileCompletenessPercent());
    }

    public function testGetShowMotivationalMessages()
    {
        $showMotivationalMessages = true;
        $profile = new Profile();
        $this->assertEquals(true, $profile->getShowMotivationalMessages());
        $profile->setShowMotivationalMessages($showMotivationalMessages);
        $this->assertEquals($showMotivationalMessages, $profile->getShowMotivationalMessages());
        $this->assertIsBool($profile->getShowMotivationalMessages());
    }

    public function testSetShowMotivationalMessages()
    {
        $showMotivationalMessages = true;
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setShowMotivationalMessages($showMotivationalMessages));
        $this->assertEquals($showMotivationalMessages, $profile->getShowMotivationalMessages());
    }

    public function testGetTheme()
    {
        $theme = Profile::THEME_DARK;
        $profile = new Profile();
        $profile->setTheme($theme);
        $this->assertEquals($theme, $profile->getTheme());
        $this->assertIsString($profile->getTheme());
    }

    public function testGetThemeFormChoices()
    {
        $this->assertCount(1, Profile::getThemeFormChoices());
        $this->assertIsArray(Profile::getThemeFormChoices());
    }

    public function testGetThemeValidationChoices()
    {
        $this->assertCount(1, Profile::getThemeValidationChoices());
        $this->assertIsArray(Profile::getThemeValidationChoices());
    }

    public function testSetTheme()
    {
        $theme = Profile::THEME_DARK;
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setTheme($theme));
        $this->assertEquals($theme, $profile->getTheme());
    }

    public function testGetTimeZone()
    {
        $timeZone = 'test time zone';
        $profile = new Profile();
        $this->assertEquals(null, $profile->getTimeZone());
        $profile->setTimeZone($timeZone);
        $this->assertEquals($timeZone, $profile->getTimeZone());
        $this->assertIsString($profile->getTimeZone());
    }

    public function testSetTimeZone()
    {
        $timeZone = 'test time zone';
        $profile = new Profile();
        $this->assertInstanceOf(Profile::class, $profile->setTimeZone($timeZone));
        $this->assertEquals($timeZone, $profile->getTimeZone());
    }
}
