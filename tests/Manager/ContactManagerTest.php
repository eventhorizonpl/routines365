<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Entity\Contact;
use App\Exception\ManagerException;
use App\Faker\UserFaker;
use App\Manager\ContactManager;
use App\Repository\ContactRepository;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ContactManagerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?ContactManager $contactManager;
    /**
     * @inject
     */
    private ?ContactRepository $contactRepository;
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
        unset(
            $this->contactManager,
            $this->contactRepository,
            $this->userFaker,
            $this->validator
        );

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $contactManager = new ContactManager($this->entityManager, $this->validator);

        $this->assertInstanceOf(ContactManager::class, $contactManager);
    }

    public function testBulkSave(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $title = 'test title';
        $contact = $user->getContacts()->first();
        $contact->setTitle($title);
        $contactId = $contact->getId();
        $contacts = [];
        $contacts[] = $contact;

        $contactManager = $this->contactManager->bulkSave($contacts, (string) $user, 1);
        $this->assertInstanceOf(ContactManager::class, $contactManager);

        $contact2 = $this->contactRepository->findOneById($contactId);
        $this->assertInstanceOf(Contact::class, $contact2);
        $this->assertEquals($title, $contact2->getTitle());
    }

    public function testDelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $contact = $user->getContacts()->first();
        $contactId = $contact->getId();

        $contactManager = $this->contactManager->delete($contact);
        $this->assertInstanceOf(ContactManager::class, $contactManager);

        $contact2 = $this->contactRepository->findOneById($contactId);
        $this->assertNull($contact2);
    }

    public function testSave(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $contact = $user->getContacts()->first();

        $contactManager = $this->contactManager->save($contact, (string) $user, true);
        $this->assertInstanceOf(ContactManager::class, $contactManager);

        $contactManager = $this->contactManager->save($contact);
        $this->assertInstanceOf(ContactManager::class, $contactManager);
    }

    public function testSaveException(): void
    {
        $this->expectException(ManagerException::class);
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $contact = $user->getContacts()->first();
        $contact->setTitle('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');

        $contactManager = $this->contactManager->save($contact, (string) $user, true);
    }

    public function testSoftDelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $contact = $user->getContacts()->first();
        $contactId = $contact->getId();

        $contactManager = $this->contactManager->softDelete($contact, (string) $user);
        $this->assertInstanceOf(ContactManager::class, $contactManager);

        $contact2 = $this->contactRepository->findOneById($contactId);
        $this->assertInstanceOf(Contact::class, $contact2);
        $this->assertTrue(null !== $contact2->getDeletedAt());
    }

    public function testUndelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $contact = $user->getContacts()->first();
        $contactId = $contact->getId();

        $contactManager = $this->contactManager->softDelete($contact, (string) $user);
        $this->assertInstanceOf(ContactManager::class, $contactManager);

        $contact2 = $this->contactRepository->findOneById($contactId);
        $this->assertInstanceOf(Contact::class, $contact2);
        $this->assertTrue(null !== $contact2->getDeletedAt());

        $contactManager = $this->contactManager->undelete($contact);
        $this->assertInstanceOf(ContactManager::class, $contactManager);

        $contact3 = $this->contactRepository->findOneById($contactId);
        $this->assertInstanceOf(Contact::class, $contact3);
        $this->assertTrue(null === $contact3->getDeletedAt());
    }

    public function testValidate(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $contact = $user->getContacts()->first();

        $errors = $this->contactManager->validate($contact);
        $this->assertCount(0, $errors);

        $contact->setTitle('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
        $errors = $this->contactManager->validate($contact);
        $this->assertCount(1, $errors);
    }
}
