<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Entity\Note;
use App\Exception\ManagerException;
use App\Faker\UserFaker;
use App\Manager\NoteManager;
use App\Repository\NoteRepository;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @internal
 */
final class NoteManagerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?EventDispatcherInterface $eventDispatcher;
    /**
     * @inject
     */
    private ?NoteManager $noteManager;
    /**
     * @inject
     */
    private ?NoteRepository $noteRepository;
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
        $this->eventDispatcher = null;
        $this->noteManager = null;
        $this->noteRepository = null;
        $this->userFaker = null;
        $this->validator = null;

        parent::tearDown();
    }

    public function createNote(): Note
    {
        $user = $this->userFaker->createRichUserPersisted();

        return $user->getNotes()->first();
    }

    public function testConstruct(): void
    {
        $noteManager = new NoteManager(
            $this->entityManager,
            $this->eventDispatcher,
            $this->validator
        );

        $this->assertInstanceOf(NoteManager::class, $noteManager);
    }

    public function testBulkSave(): void
    {
        $this->purge();
        $note = $this->createNote();
        $user = $note->getUser();
        $title = 'test title';
        $note->setTitle($title);
        $noteId = $note->getId();
        $notes = [];
        $notes[] = $note;

        $noteManager = $this->noteManager->bulkSave($notes, (string) $user, 1);
        $this->assertInstanceOf(NoteManager::class, $noteManager);

        $note2 = $this->noteRepository->findOneById($noteId);
        $this->assertInstanceOf(Note::class, $note2);
        $this->assertSame($title, $note2->getTitle());
    }

    public function testDelete(): void
    {
        $this->purge();
        $note = $this->createNote();
        $noteId = $note->getId();

        $noteManager = $this->noteManager->delete($note);
        $this->assertInstanceOf(NoteManager::class, $noteManager);

        $note2 = $this->noteRepository->findOneById($noteId);
        $this->assertNull($note2);
    }

    public function testSave(): void
    {
        $this->purge();
        $note = $this->createNote();
        $user = $note->getUser();

        $noteManager = $this->noteManager->save($note, (string) $user, true);
        $this->assertInstanceOf(NoteManager::class, $noteManager);

        $noteManager = $this->noteManager->save($note);
        $this->assertInstanceOf(NoteManager::class, $noteManager);
    }

    public function testSaveException(): void
    {
        $this->expectException(ManagerException::class);
        $this->purge();
        $note = $this->createNote();
        $user = $note->getUser();
        $note->setTitle('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');

        $noteManager = $this->noteManager->save($note, (string) $user, true);
    }

    public function testSoftDelete(): void
    {
        $this->purge();
        $note = $this->createNote();
        $user = $note->getUser();
        $noteId = $note->getId();

        $noteManager = $this->noteManager->softDelete($note, (string) $user);
        $this->assertInstanceOf(NoteManager::class, $noteManager);

        $note2 = $this->noteRepository->findOneById($noteId);
        $this->assertInstanceOf(Note::class, $note2);
        $this->assertTrue(null !== $note2->getDeletedAt());
    }

    public function testUndelete(): void
    {
        $this->purge();
        $note = $this->createNote();
        $user = $note->getUser();
        $noteId = $note->getId();

        $noteManager = $this->noteManager->softDelete($note, (string) $user);
        $this->assertInstanceOf(NoteManager::class, $noteManager);

        $note2 = $this->noteRepository->findOneById($noteId);
        $this->assertInstanceOf(Note::class, $note2);
        $this->assertTrue(null !== $note2->getDeletedAt());

        $noteManager = $this->noteManager->undelete($note);
        $this->assertInstanceOf(NoteManager::class, $noteManager);

        $note3 = $this->noteRepository->findOneById($noteId);
        $this->assertInstanceOf(Note::class, $note3);
        $this->assertTrue(null === $note3->getDeletedAt());
    }

    public function testValidate(): void
    {
        $this->purge();
        $note = $this->createNote();
        $user = $note->getUser();

        $errors = $this->noteManager->validate($note);
        $this->assertCount(0, $errors);

        $note->setTitle('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
        $errors = $this->noteManager->validate($note);
        $this->assertCount(1, $errors);
    }
}
