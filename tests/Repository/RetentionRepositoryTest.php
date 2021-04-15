<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Faker\UserFaker;
use App\Repository\RetentionRepository;
use App\Service\RetentionService;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @internal
 */
final class RetentionRepositoryTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?RetentionRepository $retentionRepository;
    /**
     * @inject
     */
    private ?RetentionService $retentionService;
    /**
     * @inject
     */
    private ?ManagerRegistry $managerRegistry;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        $this->retentionRepository = null;
        $this->retentionService = null;
        $this->managerRegistry = null;
        $this->userFaker = null
        ;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $retentionRepository = new RetentionRepository($this->managerRegistry);

        $this->assertInstanceOf(RetentionRepository::class, $retentionRepository);
    }

    public function testFindByParametersForAdmin(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $this->retentionService->run();

        $retentions = $this->retentionRepository->findByParametersForAdmin()->getResult();
        $this->assertTrue(\count($retentions) >= 1);
        $this->assertIsArray($retentions);

        $parameters = [
            'ends_at' => new DateTimeImmutable('NOW'),
        ];
        $retentions = $this->retentionRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertTrue(\count($retentions) >= 1);
        $this->assertIsArray($retentions);

        $parameters = [
            'starts_at' => new DateTimeImmutable('+1 minute'),
        ];
        $retentions = $this->retentionRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $retentions);
        $this->assertIsArray($retentions);
    }
}
