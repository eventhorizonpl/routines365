<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Faker\AchievementFaker;
use App\Repository\AchievementRepository;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @internal
 */
final class AchievementRepositoryTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?AchievementFaker $achievementFaker;
    /**
     * @inject
     */
    private ?AchievementRepository $achievementRepository;
    /**
     * @inject
     */
    private ?ManagerRegistry $managerRegistry;

    protected function tearDown(): void
    {
        $this->achievementFaker = null;
        $this->achievementRepository = null;
        $this->managerRegistry = null
        ;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $achievementRepository = new AchievementRepository($this->managerRegistry);

        $this->assertInstanceOf(AchievementRepository::class, $achievementRepository);
    }

    public function testFindByParametersForAdmin(): void
    {
        $this->purge();
        $achievement = $this->achievementFaker->createAchievementPersisted();

        $achievements = $this->achievementRepository->findByParametersForAdmin()->getResult();
        $this->assertCount(1, $achievements);
        $this->assertIsArray($achievements);

        $parameters = [
            'query' => $achievement->getName(),
        ];
        $achievements = $this->achievementRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $achievements);
        $this->assertIsArray($achievements);

        $parameters = [
            'type' => $achievement->getType(),
        ];
        $achievements = $this->achievementRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $achievements);
        $this->assertIsArray($achievements);

        $parameters = [
            'query' => 'wrong email',
        ];
        $achievements = $this->achievementRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $achievements);
        $this->assertIsArray($achievements);

        $parameters = [
            'ends_at' => new DateTimeImmutable('NOW'),
        ];
        $achievements = $this->achievementRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $achievements);
        $this->assertIsArray($achievements);

        $parameters = [
            'starts_at' => new DateTimeImmutable('+1 minute'),
        ];
        $achievements = $this->achievementRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $achievements);
        $this->assertIsArray($achievements);
    }

    public function testFindByRequirementAndType(): void
    {
        $this->purge();
        $achievement = $this->achievementFaker->createAchievementPersisted(true);

        $achievements = $this->achievementRepository->findByRequirementAndType(1000, $achievement->getType());
        $this->assertCount(1, $achievements);
        $this->assertIsArray($achievements);
    }

    public function testFindForFrontend(): void
    {
        $this->purge();
        $achievement = $this->achievementFaker->createAchievementPersisted();

        $achievements = $this->achievementRepository->findForFrontend();
        $this->assertCount(1, $achievements);
        $this->assertIsArray($achievements);
    }
}
