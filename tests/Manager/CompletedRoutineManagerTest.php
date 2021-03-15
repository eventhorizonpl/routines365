<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Entity\CompletedRoutine;
use App\Exception\ManagerException;
use App\Faker\UserFaker;
use App\Manager\CompletedRoutineManager;
use App\Repository\CompletedRoutineRepository;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @internal
 * @coversNothing
 */
final class CompletedRoutineManagerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?CompletedRoutineManager $completedRoutineManager;
    /**
     * @inject
     */
    private ?CompletedRoutineRepository $completedRoutineRepository;
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
        $this->completedRoutineManager = null;
        $this->completedRoutineRepository = null;
        $this->userFaker = null;
        $this->validator = null
        ;

        parent::tearDown();
    }

    public function createCompletedRoutine(): CompletedRoutine
    {
        $user = $this->userFaker->createRichUserPersisted();

        return $user->getCompletedRoutines()->first();
    }

    public function testConstruct(): void
    {
        $completedRoutineManager = new CompletedRoutineManager($this->entityManager, $this->validator);

        $this->assertInstanceOf(CompletedRoutineManager::class, $completedRoutineManager);
    }

    public function testBulkSave(): void
    {
        $this->purge();
        $completedRoutine = $this->createCompletedRoutine();
        $user = $completedRoutine->getUser();
        $minutesDevoted = 987;
        $completedRoutine->setMinutesDevoted($minutesDevoted);
        $completedRoutineId = $completedRoutine->getId();
        $completedRoutines = [];
        $completedRoutines[] = $completedRoutine;

        $completedRoutineManager = $this->completedRoutineManager->bulkSave($completedRoutines, (string) $user, 1);
        $this->assertInstanceOf(CompletedRoutineManager::class, $completedRoutineManager);

        $completedRoutine2 = $this->completedRoutineRepository->findOneById($completedRoutineId);
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine2);
        $this->assertSame($minutesDevoted, $completedRoutine2->getMinutesDevoted());
    }

    public function testDelete(): void
    {
        $this->purge();
        $completedRoutine = $this->createCompletedRoutine();
        $completedRoutineId = $completedRoutine->getId();

        $completedRoutineManager = $this->completedRoutineManager->delete($completedRoutine);
        $this->assertInstanceOf(CompletedRoutineManager::class, $completedRoutineManager);

        $completedRoutine2 = $this->completedRoutineRepository->findOneById($completedRoutineId);
        $this->assertNull($completedRoutine2);
    }

    public function testSave(): void
    {
        $this->purge();
        $completedRoutine = $this->createCompletedRoutine();
        $user = $completedRoutine->getUser();

        $completedRoutineManager = $this->completedRoutineManager->save($completedRoutine, (string) $user, true);
        $this->assertInstanceOf(CompletedRoutineManager::class, $completedRoutineManager);

        $completedRoutineManager = $this->completedRoutineManager->save($completedRoutine);
        $this->assertInstanceOf(CompletedRoutineManager::class, $completedRoutineManager);
    }

    public function testSaveException(): void
    {
        $this->expectException(ManagerException::class);
        $this->purge();
        $completedRoutine = $this->createCompletedRoutine();
        $user = $completedRoutine->getUser();
        $completedRoutine->setMinutesDevoted(2048);

        $completedRoutineManager = $this->completedRoutineManager->save($completedRoutine, (string) $user, true);
    }

    public function testSoftDelete(): void
    {
        $this->purge();
        $completedRoutine = $this->createCompletedRoutine();
        $user = $completedRoutine->getUser();
        $completedRoutineId = $completedRoutine->getId();

        $completedRoutineManager = $this->completedRoutineManager->softDelete($completedRoutine, (string) $user);
        $this->assertInstanceOf(CompletedRoutineManager::class, $completedRoutineManager);

        $completedRoutine2 = $this->completedRoutineRepository->findOneById($completedRoutineId);
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine2);
        $this->assertTrue(null !== $completedRoutine2->getDeletedAt());
    }

    public function testUndelete(): void
    {
        $this->purge();
        $completedRoutine = $this->createCompletedRoutine();
        $user = $completedRoutine->getUser();
        $completedRoutineId = $completedRoutine->getId();

        $completedRoutineManager = $this->completedRoutineManager->softDelete($completedRoutine, (string) $user);
        $this->assertInstanceOf(CompletedRoutineManager::class, $completedRoutineManager);

        $completedRoutine2 = $this->completedRoutineRepository->findOneById($completedRoutineId);
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine2);
        $this->assertTrue(null !== $completedRoutine2->getDeletedAt());

        $completedRoutineManager = $this->completedRoutineManager->undelete($completedRoutine);
        $this->assertInstanceOf(CompletedRoutineManager::class, $completedRoutineManager);

        $completedRoutine3 = $this->completedRoutineRepository->findOneById($completedRoutineId);
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine3);
        $this->assertTrue(null === $completedRoutine3->getDeletedAt());
    }

    public function testValidate(): void
    {
        $this->purge();
        $completedRoutine = $this->createCompletedRoutine();

        $errors = $this->completedRoutineManager->validate($completedRoutine);
        $this->assertCount(0, $errors);

        $completedRoutine->setMinutesDevoted(2048);
        $errors = $this->completedRoutineManager->validate($completedRoutine);
        $this->assertCount(1, $errors);
    }
}
