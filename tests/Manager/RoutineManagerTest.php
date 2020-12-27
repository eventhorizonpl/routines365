<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Entity\Routine;
use App\Exception\ManagerException;
use App\Faker\UserFaker;
use App\Manager\CompletedRoutineManager;
use App\Manager\GoalManager;
use App\Manager\NoteManager;
use App\Manager\ReminderManager;
use App\Manager\RewardManager;
use App\Manager\RoutineManager;
use App\Repository\RoutineRepository;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class RoutineManagerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?CompletedRoutineManager $completedRoutineManager;
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
        unset($this->completedRoutineManager);
        unset($this->goalManager);
        unset($this->noteManager);
        unset($this->reminderManager);
        unset($this->rewardManager);
        unset($this->routineManager);
        unset($this->routineRepository);
        unset($this->userFaker);
        unset($this->validator);

        parent::tearDown();
    }

    public function testConstruct()
    {
        $routineManager = new RoutineManager(
            $this->completedRoutineManager,
            $this->entityManager,
            $this->goalManager,
            $this->noteManager,
            $this->reminderManager,
            $this->rewardManager,
            $this->validator
        );

        $this->assertInstanceOf(RoutineManager::class, $routineManager);
    }

    public function testBulkSave()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $name = 'test name';
        $routine = $user->getRoutines()->first();
        $routine->setName($name);
        $routineId = $routine->getId();
        $routines = [];
        $routines[] = $routine;

        $routineManager = $this->routineManager->bulkSave($routines, (string) $user, 1);
        $this->assertInstanceOf(RoutineManager::class, $routineManager);

        $routine2 = $this->routineRepository->findOneById($routineId);
        $this->assertInstanceOf(Routine::class, $routine2);
        $this->assertEquals($name, $routine2->getName());
    }

    public function testDelete()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $routine = $user->getRoutines()->first();
        $routineId = $routine->getId();

        $routineManager = $this->routineManager->delete($routine);
        $this->assertInstanceOf(RoutineManager::class, $routineManager);

        $routine2 = $this->routineRepository->findOneById($routineId);
        $this->assertNull($routine2);
    }

    public function testSave()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $routine = $user->getRoutines()->first();

        $routineManager = $this->routineManager->save($routine, (string) $user, true);
        $this->assertInstanceOf(RoutineManager::class, $routineManager);

        $routineManager = $this->routineManager->save($routine);
        $this->assertInstanceOf(RoutineManager::class, $routineManager);
    }

    public function testSaveException()
    {
        $this->expectException(ManagerException::class);
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $routine = $user->getRoutines()->first();
        $routine->setName('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');

        $routineManager = $this->routineManager->save($routine, (string) $user, true);
    }

    public function testSoftDelete()
    {
        $this->purge();
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
        $routineId = $routine->getId();

        $routineManager = $this->routineManager->softDelete($routine, (string) $user);
        $this->assertInstanceOf(RoutineManager::class, $routineManager);

        $routine2 = $this->routineRepository->findOneById($routineId);
        $this->assertInstanceOf(Routine::class, $routine2);
        $this->assertTrue(null !== $routine2->getDeletedAt());
    }

    public function testUndelete()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $routine = $user->getRoutines()->first();
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

    public function testValidate()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $routine = $user->getRoutines()->first();

        $errors = $this->routineManager->validate($routine);
        $this->assertCount(0, $errors);

        $routine->setName('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
        $errors = $this->routineManager->validate($routine);
        $this->assertCount(1, $errors);
    }
}
