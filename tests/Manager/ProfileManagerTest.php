<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Entity\Profile;
use App\Exception\ManagerException;
use App\Faker\UserFaker;
use App\Manager\ProfileManager;
use App\Manager\ReminderManager;
use App\Repository\ProfileRepository;
use App\Tests\AbstractDoctrineTestCase;
use libphonenumber\PhoneNumberUtil;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ProfileManagerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?ProfileManager $profileManager;
    /**
     * @inject
     */
    private ?ProfileRepository $profileRepository;
    /**
     * @inject
     */
    private ?ReminderManager $reminderManager;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;
    /**
     * @inject
     */
    private ?ValidatorInterface $validator;

    protected function tearDown(): void
    {
        unset($this->profileManager);
        unset($this->profileRepository);
        unset($this->reminderManager);
        unset($this->userFaker);
        unset($this->validator);

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $profileManager = new ProfileManager(
            $this->entityManager,
            $this->reminderManager,
            $this->validator
        );

        $this->assertInstanceOf(ProfileManager::class, $profileManager);
    }

    public function testBulkSave(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $country = 'PL';
        $profile = $user->getProfile();
        $profile->setCountry($country);
        $profileId = $profile->getId();
        $profiles = [];
        $profiles[] = $profile;

        $profileManager = $this->profileManager->bulkSave($profiles, (string) $user, 1);
        $this->assertInstanceOf(ProfileManager::class, $profileManager);

        $profile2 = $this->profileRepository->findOneById($profileId);
        $this->assertInstanceOf(Profile::class, $profile2);
        $this->assertEquals($country, $profile2->getCountry());
    }

    public function testDelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $profile = $user->getProfile();
        $profileId = $profile->getId();

        $profileManager = $this->profileManager->delete($profile);
        $this->assertInstanceOf(ProfileManager::class, $profileManager);

        $profile2 = $this->profileRepository->findOneById($profileId);
        $this->assertNull($profile2);
    }

    public function testSave(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $profile = $user->getProfile();

        $profileManager = $this->profileManager->save($profile, (string) $user, true);
        $this->assertInstanceOf(ProfileManager::class, $profileManager);

        $phoneNumberUtil = PhoneNumberUtil::getInstance();
        $phone = $phoneNumberUtil->parse('+48881573056');
        $profile->setPhone($phone);
        $profileManager = $this->profileManager->save($profile, (string) $user, true);
        $this->assertInstanceOf(ProfileManager::class, $profileManager);
    }

    public function testSaveException(): void
    {
        $this->expectException(ManagerException::class);
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $profile = $user->getProfile();
        $profile->setCountry('POL');

        $profileManager = $this->profileManager->save($profile, (string) $user, true);
    }

    public function testSoftDelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $profile = $user->getProfile();
        $profileId = $profile->getId();

        $profileManager = $this->profileManager->softDelete($profile, (string) $user);
        $this->assertInstanceOf(ProfileManager::class, $profileManager);

        $profile2 = $this->profileRepository->findOneById($profileId);
        $this->assertInstanceOf(Profile::class, $profile2);
        $this->assertTrue(null !== $profile2->getDeletedAt());
    }

    public function testUndelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $profile = $user->getProfile();
        $profileId = $profile->getId();

        $profileManager = $this->profileManager->softDelete($profile, (string) $user);
        $this->assertInstanceOf(ProfileManager::class, $profileManager);

        $profile2 = $this->profileRepository->findOneById($profileId);
        $this->assertInstanceOf(Profile::class, $profile2);
        $this->assertTrue(null !== $profile2->getDeletedAt());

        $profileManager = $this->profileManager->undelete($profile);
        $this->assertInstanceOf(ProfileManager::class, $profileManager);

        $profile3 = $this->profileRepository->findOneById($profileId);
        $this->assertInstanceOf(Profile::class, $profile3);
        $this->assertTrue(null === $profile3->getDeletedAt());
    }

    public function testValidate(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $profile = $user->getProfile();

        $errors = $this->profileManager->validate($profile);
        $this->assertCount(0, $errors);

        $profile->setCountry('POL');
        $errors = $this->profileManager->validate($profile);
        $this->assertCount(1, $errors);
    }
}
