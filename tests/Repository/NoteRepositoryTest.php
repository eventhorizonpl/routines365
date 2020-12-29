<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Faker\UserFaker;
use App\Repository\NoteRepository;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;

final class NoteRepositoryTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?ManagerRegistry $managerRegistry;
    /**
     * @inject
     */
    private ?NoteRepository $noteRepository;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        unset(
            $this->managerRegistry,
            $this->noteRepository,
            $this->userFaker
        );

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $noteRepository = new NoteRepository($this->managerRegistry);

        $this->assertInstanceOf(NoteRepository::class, $noteRepository);
    }

    public function testFindByParametersForAdmin(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $notes = $this->noteRepository->findByParametersForAdmin()->getResult();
        $this->assertCount(1, $notes);
        $this->assertIsArray($notes);

        $parameters = [
            'query' => $user->getEmail(),
        ];
        $notes = $this->noteRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $notes);
        $this->assertIsArray($notes);

        $parameters = [
            'query' => 'wrong email',
        ];
        $notes = $this->noteRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $notes);
        $this->assertIsArray($notes);

        $parameters = [
            'ends_at' => new DateTimeImmutable('NOW'),
        ];
        $notes = $this->noteRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $notes);
        $this->assertIsArray($notes);

        $parameters = [
            'starts_at' => new DateTimeImmutable('+1 minute'),
        ];
        $notes = $this->noteRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $notes);
        $this->assertIsArray($notes);
    }

    public function testFindByParametersForFrontend(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $note = $user->getNotes()->first();

        $notes = $this->noteRepository->findByParametersForFrontend($user)->getResult();
        $this->assertCount(1, $notes);
        $this->assertIsArray($notes);

        $parameters = [
            'query' => $note->getTitle(),
        ];
        $notes = $this->noteRepository->findByParametersForFrontend($user, $parameters)->getResult();
        $this->assertCount(1, $notes);
        $this->assertIsArray($notes);

        $parameters = [
            'query' => 'wrong email',
        ];
        $notes = $this->noteRepository->findByParametersForFrontend($user, $parameters)->getResult();
        $this->assertCount(0, $notes);
        $this->assertIsArray($notes);
    }
}
