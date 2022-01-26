<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\Achievement;
use App\Enum\AchievementTypeEnum;
use App\Faker\{AchievementFaker, UserFaker};
use App\Manager\UserManager;
use App\Repository\AchievementRepository;
use App\Service\AchievementService;
use App\Tests\AbstractDoctrineTestCase;

/**
 * @internal
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
            AchievementTypeEnum::COMPLETED_ROUTINE
        );

        $achievement = $this->achievementService->manageAchievements(
            $user,
            AchievementTypeEnum::COMPLETED_ROUTINE
        );
        $this->assertInstanceOf(Achievement::class, $achievement);

        $achievement = $this->achievementService->manageAchievements(
            $user,
            AchievementTypeEnum::COMPLETED_GOAL
        );
        $this->assertNull($achievement);

        $achievement = $this->achievementService->manageAchievements(
            $user,
            AchievementTypeEnum::COMPLETED_PROJECT
        );
        $this->assertNull($achievement);

        $achievement = $this->achievementService->manageAchievements(
            $user,
            AchievementTypeEnum::CREATED_NOTE
        );
        $this->assertNull($achievement);
    }
}
