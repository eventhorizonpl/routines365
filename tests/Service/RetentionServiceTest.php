<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\Retention;
use App\Factory\RetentionFactory;
use App\Faker\UserFaker;
use App\Manager\RetentionManager;
use App\Repository\RetentionRepository;
use App\Repository\UserRepository;
use App\Service\RetentionService;
use App\Tests\AbstractDoctrineTestCase;
use DateTime;
use DateTimeImmutable;

/**
 * @internal
 * @coversNothing
 */
final class RetentionServiceTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?RetentionFactory $retentionFactory;
    /**
     * @inject
     */
    private ?RetentionManager $retentionManager;
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
    private ?UserFaker $userFaker;
    /**
     * @inject
     */
    private ?UserRepository $userRepository;

    protected function tearDown(): void
    {
        $this->retentionFactory = null;
        $this->retentionManager = null;
        $this->retentionRepository = null;
        $this->retentionService = null;
        $this->userFaker = null;
        $this->userRepository = null
        ;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $retentionService = new RetentionService(
            $this->retentionFactory,
            $this->retentionManager,
            $this->retentionRepository,
            $this->userRepository
        );

        $this->assertInstanceOf(RetentionService::class, $retentionService);
    }

    public function testCreate(): void
    {
        $this->purge();

        $data = ['test'];
        $date = new DateTimeImmutable();
        $retention = $this->retentionService->create(
            $data,
            $date
        );
        $this->assertInstanceOf(Retention::class, $retention);
        $this->assertSame($data, $retention->getData());
        $this->assertSame($date, $retention->getDate());
    }

    public function testFindOrCreate(): void
    {
        $this->purge();

        $data = ['test'];
        $date = new DateTimeImmutable();
        $retention = $this->retentionService->findOrCreate(
            $data,
            $date
        );
        $this->assertInstanceOf(Retention::class, $retention);
        $this->assertSame($data, $retention->getData());
        $this->assertSame($date, $retention->getDate());

        $retentions = $this->retentionRepository->findByParametersForAdmin()->getResult();
        $this->assertCount(1, $retentions);
        $this->assertIsArray($retentions);

        $data2 = ['test2'];
        $retention = $this->retentionService->findOrCreate(
            $data2,
            $date
        );
        $this->assertInstanceOf(Retention::class, $retention);
        $this->assertSame($data2, $retention->getData());
        $this->assertSame($date, $retention->getDate());

        $retentions = $this->retentionRepository->findByParametersForAdmin()->getResult();
        $this->assertCount(1, $retentions);
        $this->assertIsArray($retentions);
    }

    public function testRun(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $retentions = $this->retentionRepository->findByParametersForAdmin()->getResult();
        $this->assertCount(0, $retentions);
        $this->assertIsArray($retentions);

        $retentionService = $this->retentionService->run();
        $this->assertInstanceOf(RetentionService::class, $retentionService);

        $retentions = $this->retentionRepository->findByParametersForAdmin()->getResult();
        $this->assertCount(1, $retentions);
        $this->assertIsArray($retentions);

        $dateTime = new DateTime();
        $dateTime->modify('+1 month');

        $retentionService = $this->retentionService->run($dateTime->format('Y-m-d'));
        $this->assertInstanceOf(RetentionService::class, $retentionService);

        $retentions = $this->retentionRepository->findByParametersForAdmin()->getResult();
        $this->assertCount(2, $retentions);
        $this->assertIsArray($retentions);
    }

    public function testGetEndDate(): void
    {
        $pointerTime = new DateTime();

        $dateTime = $this->retentionService->getEndDate($pointerTime);
        $this->assertInstanceOf(DateTimeImmutable::class, $dateTime);
    }
}
