<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\Promotion;
use App\Faker\PromotionFaker;
use App\Faker\UserFaker;
use App\Manager\PromotionManager;
use App\Manager\UserManager;
use App\Repository\PromotionRepository;
use App\Service\AccountOperationService;
use App\Service\PromotionService;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;

/**
 * @internal
 * @coversNothing
 */
final class PromotionServiceTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?AccountOperationService $accountOperationService;
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
    private ?PromotionService $promotionService;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;
    /**
     * @inject
     */
    private ?UserManager $userManager;

    protected function tearDown(): void
    {
        $this->accountOperationService = null;
        $this->promotionFaker = null;
        $this->promotionManager = null;
        $this->promotionRepository = null;
        $this->promotionService = null;
        $this->userFaker = null;
        $this->userManager = null
        ;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $promotionService = new PromotionService(
            $this->accountOperationService,
            $this->promotionRepository,
            $this->userManager
        );

        $this->assertInstanceOf(PromotionService::class, $promotionService);
    }

    public function testGetEnabledAndValidPromotion(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $promotion = $this->promotionFaker->createPromotionPersisted('REWARD10', false, null, null, null, Promotion::TYPE_SYSTEM);

        $promotion2 = $this->promotionService->getEnabledAndValidPromotion(
            $promotion->getCode(),
            $promotion->getType()
        );
        $this->assertNull($promotion2);

        $promotion3 = $this->promotionFaker->createPromotionPersisted('REWARD11', true, null, null, null, Promotion::TYPE_SYSTEM);
        $promotion3->setExpiresAt(new DateTimeImmutable('2021-01-01'));
        $this->promotionManager->save($promotion3, (string) $user);

        $promotion4 = $this->promotionService->getEnabledAndValidPromotion(
            $promotion3->getCode(),
            $promotion3->getType()
        );
        $this->assertNull($promotion4);

        $promotion3->setExpiresAt(null);
        $this->promotionManager->save($promotion3, (string) $user);

        $promotion5 = $this->promotionService->getEnabledAndValidPromotion(
            $promotion3->getCode(),
            $promotion3->getType()
        );
        $this->assertInstanceOf(Promotion::class, $promotion5);
    }

    public function testApplyExistingAccountPromotion(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $promotion = $this->promotionFaker->createPromotionPersisted('REWARD9', true, null, null, null, Promotion::TYPE_SYSTEM);

        $applied = $this->promotionService->applyExistingAccountPromotion(
            $promotion->getCode(),
            $user
        );
        $this->assertFalse($applied);

        $promotion = $this->promotionFaker->createPromotionPersisted('REWARD10', true, null, null, null, Promotion::TYPE_EXISTING_ACCOUNT);

        $applied = $this->promotionService->applyExistingAccountPromotion(
            $promotion->getCode(),
            $user
        );
        $this->assertTrue($applied);
    }

    public function testApplyNewAccountPromotion(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $promotion = $this->promotionFaker->createPromotionPersisted('REWARD9', true, null, null, null, Promotion::TYPE_SYSTEM);

        $applied = $this->promotionService->applyNewAccountPromotion(
            $promotion->getCode(),
            $user
        );
        $this->assertFalse($applied);

        $promotion = $this->promotionFaker->createPromotionPersisted('REWARD10', true, null, null, null, Promotion::TYPE_NEW_ACCOUNT);

        $applied = $this->promotionService->applyNewAccountPromotion(
            $promotion->getCode(),
            $user
        );
        $this->assertTrue($applied);
    }

    public function testApplyPromotion(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $promotion = $this->promotionFaker->createPromotionPersisted('REWARD9', true, null, null, null, Promotion::TYPE_SYSTEM);

        $applied = $this->promotionService->applyPromotion(
            $promotion,
            $user
        );
        $this->assertTrue($applied);
    }

    public function testApplySystemPromotion(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $promotion = $this->promotionFaker->createPromotionPersisted('REWARD9', true, null, null, null, Promotion::TYPE_NEW_ACCOUNT);

        $applied = $this->promotionService->applySystemPromotion(
            $promotion->getCode(),
            $user
        );
        $this->assertFalse($applied);

        $promotion = $this->promotionFaker->createPromotionPersisted('REWARD10', true, null, null, null, Promotion::TYPE_SYSTEM);

        $applied = $this->promotionService->applySystemPromotion(
            $promotion->getCode(),
            $user
        );
        $this->assertTrue($applied);
    }
}
