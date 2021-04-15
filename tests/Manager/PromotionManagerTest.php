<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Entity\Promotion;
use App\Exception\ManagerException;
use App\Faker\{PromotionFaker, UserFaker};
use App\Manager\PromotionManager;
use App\Repository\PromotionRepository;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @internal
 * @coversNothing
 */
final class PromotionManagerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?PromotionFaker $promotionFaker;
    /**
     * @inject
     */
    private ?PromotionManager $promotionManager;
    /**
     * @inject
     */
    private ?PromotionRepository $promotionRepository;
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
        $this->promotionFaker = null;
        $this->promotionManager = null;
        $this->promotionRepository = null;
        $this->userFaker = null;
        $this->validator = null
        ;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $promotionManager = new PromotionManager($this->entityManager, $this->validator);

        $this->assertInstanceOf(PromotionManager::class, $promotionManager);
    }

    public function testBulkSave(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $notifications = 7;
        $promotion = $this->promotionFaker->createPromotionPersisted();
        $promotion->setNotifications($notifications);
        $promotionId = $promotion->getId();
        $promotions = [];
        $promotions[] = $promotion;

        $promotionManager = $this->promotionManager->bulkSave($promotions, (string) $user, 1);
        $this->assertInstanceOf(PromotionManager::class, $promotionManager);

        $promotion2 = $this->promotionRepository->findOneById($promotionId);
        $this->assertInstanceOf(Promotion::class, $promotion2);
        $this->assertSame($notifications, $promotion2->getNotifications());
    }

    public function testDelete(): void
    {
        $this->purge();
        $promotion = $this->promotionFaker->createPromotionPersisted();
        $promotionId = $promotion->getId();

        $promotionManager = $this->promotionManager->delete($promotion);
        $this->assertInstanceOf(PromotionManager::class, $promotionManager);

        $promotion2 = $this->promotionRepository->findOneById($promotionId);
        $this->assertNull($promotion2);
    }

    public function testSave(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $promotion = $this->promotionFaker->createPromotionPersisted();

        $promotionManager = $this->promotionManager->save($promotion, (string) $user, true);
        $this->assertInstanceOf(PromotionManager::class, $promotionManager);
    }

    public function testSaveException(): void
    {
        $this->expectException(ManagerException::class);
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $promotion = $this->promotionFaker->createPromotionPersisted();
        $promotion->setNotifications(-1);

        $promotionManager = $this->promotionManager->save($promotion, (string) $user, true);
    }

    public function testSoftDelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $promotion = $this->promotionFaker->createPromotionPersisted();
        $promotionId = $promotion->getId();

        $promotionManager = $this->promotionManager->softDelete($promotion, (string) $user);
        $this->assertInstanceOf(PromotionManager::class, $promotionManager);

        $promotion2 = $this->promotionRepository->findOneById($promotionId);
        $this->assertInstanceOf(Promotion::class, $promotion2);
        $this->assertTrue(null !== $promotion2->getDeletedAt());
    }

    public function testUndelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $promotion = $this->promotionFaker->createPromotionPersisted();
        $promotionId = $promotion->getId();

        $promotionManager = $this->promotionManager->softDelete($promotion, (string) $user);
        $this->assertInstanceOf(PromotionManager::class, $promotionManager);

        $promotion2 = $this->promotionRepository->findOneById($promotionId);
        $this->assertInstanceOf(Promotion::class, $promotion2);
        $this->assertTrue(null !== $promotion2->getDeletedAt());

        $promotionManager = $this->promotionManager->undelete($promotion);
        $this->assertInstanceOf(PromotionManager::class, $promotionManager);

        $promotion3 = $this->promotionRepository->findOneById($promotionId);
        $this->assertInstanceOf(Promotion::class, $promotion3);
        $this->assertTrue(null === $promotion3->getDeletedAt());
    }

    public function testValidate(): void
    {
        $this->purge();
        $promotion = $this->promotionFaker->createPromotionPersisted();

        $errors = $this->promotionManager->validate($promotion);
        $this->assertCount(0, $errors);

        $promotion->setNotifications(-1);
        $errors = $this->promotionManager->validate($promotion);
        $this->assertCount(1, $errors);
    }
}
