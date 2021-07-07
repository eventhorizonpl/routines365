<?php

declare(strict_types=1);

namespace App\Tests\DataPersister;

use App\DataPersister\NoteDataPersister;
use App\Entity\Note;
use App\Faker\UserFaker;
use App\Manager\NoteManager;
use App\Repository\NoteRepository;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\Security\Core\Security;

/**
 * @internal
 */
final class NoteDataPersisterTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?NoteDataPersister $noteDataPersister;
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
    private ?Security $security;

    protected function tearDown(): void
    {
        $this->noteDataPersister = null;
        $this->noteManager = null;
        $this->noteRepository = null;
        $this->userFaker = null;
        $this->security = null;

        parent::tearDown();
    }

    public function createNote(): Note
    {
        $user = $this->userFaker->createRichUserPersisted();

        return $user->getNotes()->first();
    }

    public function testConstruct(): void
    {
        $noteDataPersister = new NoteDataPersister($this->noteManager, $this->security);

        $this->assertInstanceOf(NoteDataPersister::class, $noteDataPersister);
    }

    public function testSupports(): void
    {
        $this->purge();
        $note = $this->createNote();
        $user = $note->getUser();

        $this->assertTrue($this->noteDataPersister->supports($note));
        $this->assertFalse($this->noteDataPersister->supports($user));
    }

    public function testPersist(): void
    {
        $this->purge();
        $note = $this->createNote();
        $user = $note->getUser();

        $security = $this->createStub(Security::class);
        $security->method('getUser')
            ->willReturn($user)
        ;

        $noteDataPersister = new NoteDataPersister($this->noteManager, $security);

        $this->assertInstanceOf(Note::class, $noteDataPersister->persist($note));
    }

    public function testRemove(): void
    {
        $this->purge();
        $note = $this->createNote();
        $user = $note->getUser();
        $noteId = $note->getId();

        $security = $this->createStub(Security::class);
        $security->method('getUser')
            ->willReturn($user)
        ;

        $noteDataPersister = new NoteDataPersister($this->noteManager, $security);

        $this->assertNull($noteDataPersister->remove($note));

        $note2 = $this->noteRepository->findOneById($noteId);
        $this->assertInstanceOf(Note::class, $note2);
        $this->assertTrue(null !== $note2->getDeletedAt());
    }
}
