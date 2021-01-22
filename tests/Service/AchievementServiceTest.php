<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\Achievement;
use App\Faker\UserFaker;
use App\Manager\UserManager;
use App\Repository\AchievementRepository;
use App\Service\AchievementService;
use App\Tests\AbstractDoctrineTestCase;

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
    private ?UserManager $userManager;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        unset(
            $this->achievementRepository,
            $this->achievementService,
            $this->userManager,
            $this->userFaker
        );

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $achievementService = new AchievementService($this->achievementRepository, $this->userManager);

        $this->assertInstanceOf(AchievementService::class, $achievementService);
    }

    public function testDeposit(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $achievement = $this->achievementService->manageAchievements(
            $user,
            Achievement::TYPE_COMPLETED_ROUTINE
        );
        $this->assertNull($achievement);

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
