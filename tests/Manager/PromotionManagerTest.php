<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Entity\Promotion;
use App\Exception\ManagerException;
use App\Faker\PromotionFaker;
use App\Faker\UserFaker;
use App\Manager\PromotionManager;
use App\Repository\PromotionRepository;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
        unset($this->promotionFaker);
        unset($this->promotionManager);
        unset($this->promotionRepository);
        unset($this->userFaker);
        unset($this->validator);

        parent::tearDown();
    }

    public function testConstruct()
    {
        $promotionManager = new PromotionManager($this->entityManager, $this->validator);

        $this->assertInstanceOf(PromotionManager::class, $promotionManager);
    }

    public function testBulkSave()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $emailNotifications = 7;
        $promotion = $this->promotionFaker->createPromotionPersisted();
        $promotion->setEmailNotifications($emailNotifications);
        $promotionId = $promotion->getId();
        $promotions = [];
        $promotions[] = $promotion;

        $promotionManager = $this->promotionManager->bulkSave($promotions, (string) $user, 1);
        $this->assertInstanceOf(PromotionManager::class, $promotionManager);

        $promotion2 = $this->promotionRepository->findOneById($promotionId);
        $this->assertInstanceOf(Promotion::class, $promotion2);
        $this->assertEquals($emailNotifications, $promotion2->getEmailNotifications());
    }

    public function testDelete()
    {
        $this->purge();
        $promotion = $this->promotionFaker->createPromotionPersisted();
        $promotionId = $promotion->getId();

        $promotionManager = $this->promotionManager->delete($promotion);
        $this->assertInstanceOf(PromotionManager::class, $promotionManager);

        $promotion2 = $this->promotionRepository->findOneById($promotionId);
        $this->assertNull($promotion2);
    }

    public function testSave()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $promotion = $this->promotionFaker->createPromotionPersisted();

        $promotionManager = $this->promotionManager->save($promotion, (string) $user, true);
        $this->assertInstanceOf(PromotionManager::class, $promotionManager);
    }

    public function testSaveException()
    {
        $this->expectException(ManagerException::class);
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $promotion = $this->promotionFaker->createPromotionPersisted();
        $promotion->setEmailNotifications(-1);

        $promotionManager = $this->promotionManager->save($promotion, (string) $user, true);
    }

    public function testSoftDelete()
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

    public function testUndelete()
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

    public function testValidate()
    {
        $this->purge();
        $promotion = $this->promotionFaker->createPromotionPersisted();

        $errors = $this->promotionManager->validate($promotion);
        $this->assertCount(0, $errors);

        $promotion->setEmailNotifications(-1);
        $errors = $this->promotionManager->validate($promotion);
        $this->assertCount(1, $errors);
    }
}