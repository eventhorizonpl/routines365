<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\Achievement;
use App\Faker\{AchievementFaker, UserFaker};
use App\Manager\UserManager;
use App\Repository\AchievementRepository;
use App\Service\AchievementService;
use App\Tests\AbstractDoctrineTestCase;

/**
 * @internal
 * @coversNothing
 */
final class AchievementServiceTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?AchievementRepository $achievementRepository;
    /**
     * @inject
     */
    private ?AchievementService $achievementService;
    /**
     * @inject
     */
    private ?AchievementFaker $achievementFaker;
    /**
     * @inject
     */
    private ?UserManager $userManager;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        $this->achievementRepository = null;
        $this->achievementService = null;
        $this->achievementFaker = null;
        $this->userManager = null;
        $this->userFaker = null
        ;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $achievementService = new AchievementService($this->achievementRepository, $this->userManager);

        $this->assertInstanceOf(AchievementService::class, $achievementService);
    }

    public function testManageAchievements(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $this->achievementFaker->createAchievementPersisted(
            true,
            1,
            'test achievement',
            1,
            Achievement::TYPE_COMPLETED_ROUTINE
        );

        $achievement = $this->achievementService->manageAchievements(
            $user,
            Achievement::TYPE_COMPLETED_ROUTINE
        );
        $this->assertInstanceOf(Achievement::class, $achievement);

        $achievement = $this->achievementService->manageAchievements(
            $user,
            Achievement::TYPE_COMPLETED_GOAL
        );
        $this->assertNull($achievement);

        $achievement = $this->achievementService->manageAchievements(
            $user,
            Achievement::TYPE_COMPLETED_PROJECT
        );
        $this->assertNull($achievement);

        $achievement = $this->achievementService->manageAchievements(
            $user,
            Achievement::TYPE_CREATED_NOTE
        );
        $this->assertNull($achievement);

        $achievement = $this->achievementService->manageAchievements(
            $user,
            'something else'
        );
        $this->assertNull($achievement);
    }
}
