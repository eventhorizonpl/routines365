<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Entity\Reward;
use App\Exception\ManagerException;
use App\Faker\UserFaker;
use App\Manager\RewardManager;
use App\Repository\RewardRepository;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @internal
 */
final class RewardManagerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?EventDispatcherInterface $eventDispatcher;
    /**
     * @inject
     */
    private ?RewardManager $rewardManager;
    /**
     * @inject
     */
    private ?RewardRepository $rewardRepository;
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
        $this->rewardManager = null;
        $this->rewardRepository = null;
        $this->userFaker = null;
        $this->validator = null;

        parent::tearDown();
    }

    public function createReward(): Reward
    {
        $user = $this->userFaker->createRichUserPersisted();

        return $user->getRewards()->first();
    }

    public function testConstruct(): void
    {
        $rewardManager = new RewardManager(
            $this->entityManager,
            $this->eventDispatcher,
            $this->validator
        );

        $this->assertInstanceOf(RewardManager::class, $rewardManager);
    }

    public function testBulkSave(): void
    {
        $this->purge();
        $reward = $this->createReward();
        $user = $reward->getUser();
        $name = 'test name';
        $reward->setName($name);
        $rewardId = $reward->getId();
        $rewards = [];
        $rewards[] = $reward;

        $rewardManager = $this->rewardManager->bulkSave($rewards, (string) $user, 1);
        $this->assertInstanceOf(RewardManager::class, $rewardManager);

        $reward2 = $this->rewardRepository->findOneById($rewardId);
        $this->assertInstanceOf(Reward::class, $reward2);
        $this->assertSame($name, $reward2->getName());
    }

    public function testDelete(): void
    {
        $this->purge();
        $reward = $this->createReward();
        $rewardId = $reward->getId();

        $rewardManager = $this->rewardManager->delete($reward);
        $this->assertInstanceOf(RewardManager::class, $rewardManager);

        $reward2 = $this->rewardRepository->findOneById($rewardId);
        $this->assertNull($reward2);
    }

    public function testSave(): void
    {
        $this->purge();
        $reward = $this->createReward();
        $user = $reward->getUser();

        $rewardManager = $this->rewardManager->save($reward, (string) $user, true);
        $this->assertInstanceOf(RewardManager::class, $rewardManager);

        $rewardManager = $this->rewardManager->save($reward);
        $this->assertInstanceOf(RewardManager::class, $rewardManager);
    }

    public function testSaveException(): void
    {
        $this->expectException(ManagerException::class);
        $this->purge();
        $reward = $this->createReward();
        $user = $reward->getUser();
        $reward->setName('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');

        $rewardManager = $this->rewardManager->save($reward, (string) $user, true);
    }

    public function testSoftDelete(): void
    {
        $this->purge();
        $reward = $this->createReward();
        $user = $reward->getUser();
        $rewardId = $reward->getId();

        $rewardManager = $this->rewardManager->softDelete($reward, (string) $user);
        $this->assertInstanceOf(RewardManager::class, $rewardManager);

        $reward2 = $this->rewardRepository->findOneById($rewardId);
        $this->assertInstanceOf(Reward::class, $reward2);
        $this->assertTrue(null !== $reward2->getDeletedAt());
    }

    public function testUndelete(): void
    {
        $this->purge();
        $reward = $this->createReward();
        $user = $reward->getUser();
        $rewardId = $reward->getId();

        $rewardManager = $this->rewardManager->softDelete($reward, (string) $user);
        $this->assertInstanceOf(RewardManager::class, $rewardManager);

        $reward2 = $this->rewardRepository->findOneById($rewardId);
        $this->assertInstanceOf(Reward::class, $reward2);
        $this->assertTrue(null !== $reward2->getDeletedAt());

        $rewardManager = $this->rewardManager->undelete($reward);
        $this->assertInstanceOf(RewardManager::class, $rewardManager);

        $reward3 = $this->rewardRepository->findOneById($rewardId);
        $this->assertInstanceOf(Reward::class, $reward3);
        $this->assertTrue(null === $reward3->getDeletedAt());
    }

    public function testValidate(): void
    {
        $this->purge();
        $reward = $this->createReward();

        $errors = $this->rewardManager->validate($reward);
        $this->assertCount(0, $errors);

        $reward->setName('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
        $errors = $this->rewardManager->validate($reward);
        $this->assertCount(1, $errors);
    }
}
