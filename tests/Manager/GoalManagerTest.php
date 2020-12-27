<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Entity\Goal;
use App\Exception\ManagerException;
use App\Faker\UserFaker;
use App\Manager\GoalManager;
use App\Repository\GoalRepository;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class GoalManagerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?GoalManager $goalManager;
    /**
     * @inject
     */
    private ?GoalRepository $goalRepository;
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
        unset($this->goalManager);
        unset($this->goalRepository);
        unset($this->userFaker);
        unset($this->validator);

        parent::tearDown();
    }

    public function testConstruct()
    {
        $goalManager = new GoalManager($this->entityManager, $this->validator);

        $this->assertInstanceOf(GoalManager::class, $goalManager);
    }

    public function testBulkSave()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $name = 'test name';
        $goal = $user->getGoals()->first();
        $goal->setName($name);
        $goalId = $goal->getId();
        $goals = [];
        $goals[] = $goal;

        $goalManager = $this->goalManager->bulkSave($goals, (string) $user, 1);
        $this->assertInstanceOf(GoalManager::class, $goalManager);

        $goal2 = $this->goalRepository->findOneById($goalId);
        $this->assertInstanceOf(Goal::class, $goal2);
        $this->assertEquals($name, $goal2->getName());
    }

    public function testDelete()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $goal = $user->getGoals()->first();
        $goalId = $goal->getId();

        $goalManager = $this->goalManager->delete($goal);
        $this->assertInstanceOf(GoalManager::class, $goalManager);

        $goal2 = $this->goalRepository->findOneById($goalId);
        $this->assertNull($goal2);
    }

    public function testSave()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $goal = $user->getGoals()->first();

        $goalManager = $this->goalManager->save($goal, (string) $user, true);
        $this->assertInstanceOf(GoalManager::class, $goalManager);

        $goal->setIsCompleted(false);
        $goal->setCompletedAt(new DateTimeImmutable());
        $goalManager = $this->goalManager->save($goal);
        $this->assertInstanceOf(GoalManager::class, $goalManager);
    }

    public function testSaveException()
    {
        $this->expectException(ManagerException::class);
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $goal = $user->getGoals()->first();
        $goal->setName('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');

        $goalManager = $this->goalManager->save($goal, (string) $user, true);
    }

    public function testSoftDelete()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $goal = $user->getGoals()->first();
        $goalId = $goal->getId();

        $goalManager = $this->goalManager->softDelete($goal, (string) $user);
        $this->assertInstanceOf(GoalManager::class, $goalManager);

        $goal2 = $this->goalRepository->findOneById($goalId);
        $this->assertInstanceOf(Goal::class, $goal2);
        $this->assertTrue(null !== $goal2->getDeletedAt());
    }

    public function testUndelete()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $goal = $user->getGoals()->first();
        $goalId = $goal->getId();

        $goalManager = $this->goalManager->softDelete($goal, (string) $user);
        $this->assertInstanceOf(GoalManager::class, $goalManager);

        $goal2 = $this->goalRepository->findOneById($goalId);
        $this->assertInstanceOf(Goal::class, $goal2);
        $this->assertTrue(null !== $goal2->getDeletedAt());

        $goalManager = $this->goalManager->undelete($goal);
        $this->assertInstanceOf(GoalManager::class, $goalManager);

        $goal3 = $this->goalRepository->findOneById($goalId);
        $this->assertInstanceOf(Goal::class, $goal3);
        $this->assertTrue(null === $goal3->getDeletedAt());
    }

    public function testValidate()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $goal = $user->getGoals()->first();

        $errors = $this->goalManager->validate($goal);
        $this->assertCount(0, $errors);

        $goal->setName('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
        $errors = $this->goalManager->validate($goal);
        $this->assertCount(1, $errors);
    }
}
