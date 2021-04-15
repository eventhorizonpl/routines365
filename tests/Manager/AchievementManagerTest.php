<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Entity\Achievement;
use App\Exception\ManagerException;
use App\Faker\{AchievementFaker, UserFaker};
use App\Manager\AchievementManager;
use App\Repository\AchievementRepository;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @internal
 * @coversNothing
 */
final class AchievementManagerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?AchievementFaker $achievementFaker;
    /**
     * @inject
     */
    private ?AchievementManager $achievementManager;
    /**
     * @inject
     */
    private ?AchievementRepository $achievementRepository;
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
        $this->achievementFaker = null;
        $this->achievementManager = null;
        $this->achievementRepository = null;
        $this->userFaker = null;
        $this->validator = null
        ;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $achievementManager = new AchievementManager($this->entityManager, $this->validator);

        $this->assertInstanceOf(AchievementManager::class, $achievementManager);
    }

    public function testBulkSave(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $level = 7;
        $achievement = $this->achievementFaker->createAchievementPersisted();
        $achievement->setLevel($level);
        $achievementId = $achievement->getId();
        $achievements = [];
        $achievements[] = $achievement;

        $achievementManager = $this->achievementManager->bulkSave($achievements, (string) $user, 1);
        $this->assertInstanceOf(AchievementManager::class, $achievementManager);

        $achievement2 = $this->achievementRepository->findOneById($achievementId);
        $this->assertInstanceOf(Achievement::class, $achievement2);
        $this->assertSame($level, $achievement2->getLevel());
    }

    public function testDelete(): void
    {
        $this->purge();
        $achievement = $this->achievementFaker->createAchievementPersisted();
        $achievementId = $achievement->getId();

        $achievementManager = $this->achievementManager->delete($achievement);
        $this->assertInstanceOf(AchievementManager::class, $achievementManager);

        $achievement2 = $this->achievementRepository->findOneById($achievementId);
        $this->assertNull($achievement2);
    }

    public function testSave(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $achievement = $this->achievementFaker->createAchievementPersisted();

        $achievementManager = $this->achievementManager->save($achievement, (string) $user, true);
        $this->assertInstanceOf(AchievementManager::class, $achievementManager);
    }

    public function testSaveException(): void
    {
        $this->expectException(ManagerException::class);
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $achievement = $this->achievementFaker->createAchievementPersisted();
        $achievement->setLevel(-1);

        $achievementManager = $this->achievementManager->save($achievement, (string) $user, true);
    }

    public function testSoftDelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $achievement = $this->achievementFaker->createAchievementPersisted();
        $achievementId = $achievement->getId();

        $achievementManager = $this->achievementManager->softDelete($achievement, (string) $user);
        $this->assertInstanceOf(AchievementManager::class, $achievementManager);

        $achievement2 = $this->achievementRepository->findOneById($achievementId);
        $this->assertInstanceOf(Achievement::class, $achievement2);
        $this->assertTrue(null !== $achievement2->getDeletedAt());
    }

    public function testUndelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $achievement = $this->achievementFaker->createAchievementPersisted();
        $achievementId = $achievement->getId();

        $achievementManager = $this->achievementManager->softDelete($achievement, (string) $user);
        $this->assertInstanceOf(AchievementManager::class, $achievementManager);

        $achievement2 = $this->achievementRepository->findOneById($achievementId);
        $this->assertInstanceOf(Achievement::class, $achievement2);
        $this->assertTrue(null !== $achievement2->getDeletedAt());

        $achievementManager = $this->achievementManager->undelete($achievement);
        $this->assertInstanceOf(AchievementManager::class, $achievementManager);

        $achievement3 = $this->achievementRepository->findOneById($achievementId);
        $this->assertInstanceOf(Achievement::class, $achievement3);
        $this->assertTrue(null === $achievement3->getDeletedAt());
    }

    public function testValidate(): void
    {
        $this->purge();
        $achievement = $this->achievementFaker->createAchievementPersisted();

        $errors = $this->achievementManager->validate($achievement);
        $this->assertCount(0, $errors);

        $achievement->setLevel(100);
        $errors = $this->achievementManager->validate($achievement);
        $this->assertCount(1, $errors);
    }
}
