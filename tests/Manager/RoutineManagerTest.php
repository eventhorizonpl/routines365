<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Entity\Routine;
use App\Exception\ManagerException;
use App\Faker\UserFaker;
use App\Manager\{CompletedRoutineManager, GoalManager, NoteManager, ReminderManager, RewardManager, RoutineManager};
use App\Repository\RoutineRepository;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @internal
 */
final class RoutineManagerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?CompletedRoutineManager $completedRoutineManager;
    /**
     * @inject
     */
    private ?EventDispatcherInterface $eventDispatcher;
    /**
     * @inject
     */
    private ?GoalManager $goalManager;
    /**
     * @inject
     */
    private ?NoteManager $noteManager;
    /**
     * @inject
     */
    private ?ReminderManager $reminderManager;
    /**
     * @inject
     */
    private ?RewardManager $rewardManager;
    /**
     * @inject
     */
    private ?RoutineManager $routineManager;
    /**
     * @inject
     */
    private ?RoutineRepository $routineRepository;
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
        $this->eventDispatcher = null;
        $this->goalManager = null;
        $this->noteManager = null;
        $this->reminderManager = null;
        $this->rewardManager = null;
        $this->routineManager = null;
        $this->routineRepository = null;
        $this->userFaker = null;
        $this->validator = null;

        parent::tearDown();
    }

    public function createRoutine(): Routine
    {
        $user = $this->userFaker->createRichUserPersisted();
        $completedRoutine = $user->getCompletedRoutines()->first();
        $goal = $user->getGoals()->first();
        $note = $user->getNotes()->first();
        $reminder = $user->getReminders()->first();
        $reward = $user->getRewards()->first();
        $routine = $user->getRoutines()->first();
        $routine->addCompletedRoutine($completedRoutine);
        $routine->addGoal($goal);
        $routine->addNote($note);
        $routine->addReminder($reminder);
        $routine->addReward($reward);

        return $routine;
    }

    public function testConstruct(): void
    {
        $routineManager = new RoutineManager(
            $this->completedRoutineManager,
            $this->entityManager,
            $this->eventDispatcher,
            $this->goalManager,
            $this->noteManager,
            $this->reminderManager,
            $this->rewardManager,
            $this->validator
        );

        $this->assertInstanceOf(RoutineManager::class, $routineManager);
    }

    public function testBulkSave(): void
    {
        $this->purge();
        $routine = $this->createRoutine();
        $user = $routine->getUser();
        $name = 'test name';
        $routine->setName($name);
        $routineId = $routine->getId();
        $routines = [];
        $routines[] = $routine;

        $routineManager = $this->routineManager->bulkSave($routines, (string) $user, 1);
        $this->assertInstanceOf(RoutineManager::class, $routineManager);

        $routine2 = $this->routineRepository->findOneById($routineId);
        $this->assertInstanceOf(Routine::class, $routine2);
        $this->assertSame($name, $routine2->getName());
    }

    public function testDelete(): void
    {
        $this->purge();
        $routine = $this->createRoutine();
        $routineId = $routine->getId();

        $routineManager = $this->routineManager->delete($routine);
        $this->assertInstanceOf(RoutineManager::class, $routineManager);

        $routine2 = $this->routineRepository->findOneById($routineId);
        $this->assertNull($routine2);
    }

    public function testSave(): void
    {
        $this->purge();
        $routine = $this->createRoutine();
        $user = $routine->getUser();

        $routineManager = $this->routineManager->save($routine, (string) $user, true);
        $this->assertInstanceOf(RoutineManager::class, $routineManager);

        $routineManager = $this->routineManager->save($routine);
        $this->assertInstanceOf(RoutineManager::class, $routineManager);
    }

    public function testSaveException(): void
    {
        $this->expectException(ManagerException::class);
        $this->purge();
        $routine = $this->createRoutine();
        $user = $routine->getUser();
        $routine->setName('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');

        $routineManager = $this->routineManager->save($routine, (string) $user, true);
    }

    public function testSoftDelete(): void
    {
        $this->purge();
        $routine = $this->createRoutine();
        $user = $routine->getUser();
        $routineId = $routine->getId();

        $routineManager = $this->routineManager->softDelete($routine, (string) $user);
        $this->assertInstanceOf(RoutineManager::class, $routineManager);

        $routine2 = $this->routineRepository->findOneById($routineId);
        $this->assertInstanceOf(Routine::class, $routine2);
        $this->assertTrue(null !== $routine2->getDeletedAt());
    }

    public function testUndelete(): void
    {
        $this->purge();
        $routine = $this->createRoutine();
        $user = $routine->getUser();
        $routineId = $routine->getId();

        $routineManager = $this->routineManager->softDelete($routine, (string) $user);
        $this->assertInstanceOf(RoutineManager::class, $routineManager);

        $routine2 = $this->routineRepository->findOneById($routineId);
        $this->assertInstanceOf(Routine::class, $routine2);
        $this->assertTrue(null !== $routine2->getDeletedAt());

        $routineManager = $this->routineManager->undelete($routine);
        $this->assertInstanceOf(RoutineManager::class, $routineManager);

        $routine3 = $this->routineRepository->findOneById($routineId);
        $this->assertInstanceOf(Routine::class, $routine3);
        $this->assertTrue(null === $routine3->getDeletedAt());
    }

    public function testValidate(): void
    {
        $this->purge();
        $routine = $this->createRoutine();

        $errors = $this->routineManager->validate($routine);
        $this->assertCount(0, $errors);

        $routine->setName('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
        $errors = $this->routineManager->validate($routine);
        $this->assertCount(1, $errors);
    }
}
