<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Entity\SavedEmail;
use App\Exception\ManagerException;
use App\Faker\UserFaker;
use App\Manager\SavedEmailManager;
use App\Repository\SavedEmailRepository;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class SavedEmailManagerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?SavedEmailManager $savedEmailManager;
    /**
     * @inject
     */
    private ?SavedEmailRepository $savedEmailRepository;
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
        unset($this->savedEmailManager);
        unset($this->savedEmailRepository);
        unset($this->userFaker);
        unset($this->validator);

        parent::tearDown();
    }

    public function testConstruct()
    {
        $savedEmailManager = new SavedEmailManager($this->entityManager, $this->validator);

        $this->assertInstanceOf(SavedEmailManager::class, $savedEmailManager);
    }

    public function testBulkSave()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $email = 'test@example.org';
        $savedEmail = $user->getSavedEmails()->first();
        $savedEmail->setEmail($email);
        $savedEmailId = $savedEmail->getId();
        $savedEmails = [];
        $savedEmails[] = $savedEmail;

        $savedEmailManager = $this->savedEmailManager->bulkSave($savedEmails, (string) $user, 1);
        $this->assertInstanceOf(SavedEmailManager::class, $savedEmailManager);

        $savedEmail2 = $this->savedEmailRepository->findOneById($savedEmailId);
        $this->assertInstanceOf(SavedEmail::class, $savedEmail2);
        $this->assertEquals($email, $savedEmail2->getEmail());
    }

    public function testDelete()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $savedEmail = $user->getSavedEmails()->first();
        $savedEmailId = $savedEmail->getId();

        $savedEmailManager = $this->savedEmailManager->delete($savedEmail);
        $this->assertInstanceOf(SavedEmailManager::class, $savedEmailManager);

        $savedEmail2 = $this->savedEmailRepository->findOneById($savedEmailId);
        $this->assertNull($savedEmail2);
    }

    public function testSave()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $savedEmail = $user->getSavedEmails()->first();

        $savedEmailManager = $this->savedEmailManager->save($savedEmail, (string) $user, true);
        $this->assertInstanceOf(SavedEmailManager::class, $savedEmailManager);

        $savedEmailManager = $this->savedEmailManager->save($savedEmail);
        $this->assertInstanceOf(SavedEmailManager::class, $savedEmailManager);
    }

    public function testSaveException()
    {
        $this->expectException(ManagerException::class);
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $savedEmail = $user->getSavedEmails()->first();
        $savedEmail->setEmail('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');

        $savedEmailManager = $this->savedEmailManager->save($savedEmail, (string) $user, true);
    }

    public function testSoftDelete()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $savedEmail = $user->getSavedEmails()->first();
        $savedEmailId = $savedEmail->getId();

        $savedEmailManager = $this->savedEmailManager->softDelete($savedEmail, (string) $user);
        $this->assertInstanceOf(SavedEmailManager::class, $savedEmailManager);

        $savedEmail2 = $this->savedEmailRepository->findOneById($savedEmailId);
        $this->assertInstanceOf(SavedEmail::class, $savedEmail2);
        $this->assertTrue(null !== $savedEmail2->getDeletedAt());
    }

    public function testUndelete()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $savedEmail = $user->getSavedEmails()->first();
        $savedEmailId = $savedEmail->getId();

        $savedEmailManager = $this->savedEmailManager->softDelete($savedEmail, (string) $user);
        $this->assertInstanceOf(SavedEmailManager::class, $savedEmailManager);

        $savedEmail2 = $this->savedEmailRepository->findOneById($savedEmailId);
        $this->assertInstanceOf(SavedEmail::class, $savedEmail2);
        $this->assertTrue(null !== $savedEmail2->getDeletedAt());

        $savedEmailManager = $this->savedEmailManager->undelete($savedEmail);
        $this->assertInstanceOf(SavedEmailManager::class, $savedEmailManager);

        $savedEmail3 = $this->savedEmailRepository->findOneById($savedEmailId);
        $this->assertInstanceOf(SavedEmail::class, $savedEmail3);
        $this->assertTrue(null === $savedEmail3->getDeletedAt());
    }

    public function testValidate()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $savedEmail = $user->getSavedEmails()->first();

        $errors = $this->savedEmailManager->validate($savedEmail);
        $this->assertCount(0, $errors);

        $savedEmail->setEmail('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
        $errors = $this->savedEmailManager->validate($savedEmail);
        $this->assertCount(2, $errors);
    }
}
