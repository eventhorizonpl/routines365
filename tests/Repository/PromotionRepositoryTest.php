<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Entity\Promotion;
use App\Faker\PromotionFaker;
use App\Repository\PromotionRepository;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;

final class PromotionRepositoryTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?ManagerRegistry $managerRegistry;
    /**
     * @inject
     */
    private ?PromotionFaker $promotionFaker;
    /**
     * @inject
     */
    private ?PromotionRepository $promotionRepository;

    protected function tearDown(): void
    {
        unset(
            $this->managerRegistry,
            $this->promotionFaker,
            $this->promotionRepository
        );

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $promotionRepository = new PromotionRepository($this->managerRegistry);

        $this->assertInstanceOf(PromotionRepository::class, $promotionRepository);
    }

    public function testFindByParametersForAdmin(): void
    {
        $this->purge();
        $promotion = $this->promotionFaker->createPromotionPersisted();

        $promotions = $this->promotionRepository->findByParametersForAdmin()->getResult();
        $this->assertCount(1, $promotions);
        $this->assertIsArray($promotions);

        $parameters = [
            'query' => $promotion->getName(),
        ];
        $promotions = $this->promotionRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $promotions);
        $this->assertIsArray($promotions);

        $parameters = [
            'type' => $promotion->getType(),
        ];
        $promotions = $this->promotionRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $promotions);
        $this->assertIsArray($promotions);

        $parameters = [
            'query' => 'wrong email',
        ];
        $promotions = $this->promotionRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $promotions);
        $this->assertIsArray($promotions);

        $parameters = [
            'ends_at' => new DateTimeImmutable('NOW'),
        ];
        $promotions = $this->promotionRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $promotions);
        $this->assertIsArray($promotions);

        $parameters = [
            'starts_at' => new DateTimeImmutable('+1 minute'),
        ];
        $promotions = $this->promotionRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $promotions);
        $this->assertIsArray($promotions);
    }

    public function testFindOneByCodeAndType(): void
    {
        $this->purge();
        $promotion = $this->promotionFaker->createPromotionPersisted(null, null, null, true);

        $promotion2 = $this->promotionRepository->findOneByCodeAndType($promotion->getCode(), $promotion->getType());
        $this->assertInstanceOf(Promotion::class, $promotion2);
    }
}
