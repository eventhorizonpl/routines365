<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Entity\Contact;
use App\Exception\ManagerException;
use App\Faker\UserFaker;
use App\Manager\ContactManager;
use App\Repository\ContactRepository;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @internal
 */
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
    private ?EventDispatcherInterface $eventDispatcher;
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
        $this->contactManager = null;
        $this->contactRepository = null;
        $this->eventDispatcher = null;
        $this->userFaker = null;
        $this->validator = null;

        parent::tearDown();
    }

    public function createContact(): Contact
    {
        $user = $this->userFaker->createRichUserPersisted();

        return $user->getContacts()->first();
    }

    public function testConstruct(): void
    {
        $contactManager = new ContactManager(
            $this->entityManager,
            $this->eventDispatcher,
            $this->validator
        );

        $this->assertInstanceOf(ContactManager::class, $contactManager);
    }

    public function testBulkSave(): void
    {
        $this->purge();
        $contact = $this->createContact();
        $user = $contact->getUser();
        $title = 'test title';
        $contact->setTitle($title);
        $contactId = $contact->getId();
        $contacts = [];
        $contacts[] = $contact;

        $contactManager = $this->contactManager->bulkSave($contacts, (string) $user, 1);
        $this->assertInstanceOf(ContactManager::class, $contactManager);

        $contact2 = $this->contactRepository->findOneById($contactId);
        $this->assertInstanceOf(Contact::class, $contact2);
        $this->assertSame($title, $contact2->getTitle());
    }

    public function testDelete(): void
    {
        $this->purge();
        $contact = $this->createContact();
        $contactId = $contact->getId();

        $contactManager = $this->contactManager->delete($contact);
        $this->assertInstanceOf(ContactManager::class, $contactManager);

        $contact2 = $this->contactRepository->findOneById($contactId);
        $this->assertNull($contact2);
    }

    public function testSave(): void
    {
        $this->purge();
        $contact = $this->createContact();
        $user = $contact->getUser();

        $contactManager = $this->contactManager->save($contact, (string) $user, true);
        $this->assertInstanceOf(ContactManager::class, $contactManager);

        $contactManager = $this->contactManager->save($contact);
        $this->assertInstanceOf(ContactManager::class, $contactManager);
    }

    public function testSaveException(): void
    {
        $this->expectException(ManagerException::class);
        $this->purge();
        $contact = $this->createContact();
        $user = $contact->getUser();
        $contact->setTitle('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');

        $contactManager = $this->contactManager->save($contact, (string) $user, true);
    }

    public function testSoftDelete(): void
    {
        $this->purge();
        $contact = $this->createContact();
        $user = $contact->getUser();
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
        $contact = $this->createContact();
        $user = $contact->getUser();
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
        $contact = $this->createContact();

        $errors = $this->contactManager->validate($contact);
        $this->assertCount(0, $errors);

        $contact->setTitle('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
        $errors = $this->contactManager->validate($contact);
        $this->assertCount(1, $errors);
    }
}
