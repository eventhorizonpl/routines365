<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\User;
use App\Faker\UserFaker;
use App\Manager\UserKytManager;
use App\Manager\UserManager;
use App\Repository\UserRepository;
use App\Service\EmailService;
use App\Service\PromotionService;
use App\Service\UserKytService;
use App\Tests\AbstractDoctrineTestCase;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class UserKytServiceTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?PaginatorInterface $paginator;
    /**
     * @inject
     */
    private ?PromotionService $promotionService;
    /**
     * @inject
     */
    private ?TranslatorInterface $translator;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;
    /**
     * @inject
     */
    private ?UserKytManager $userKytManager;
    /**
     * @inject
     */
    private ?UserKytService $userKytService;
    /**
     * @inject
     */
    private ?UserManager $userManager;
    /**
     * @inject
     */
    private ?UserRepository $userRepository;

    protected function tearDown(): void
    {
        unset(
            $this->paginator,
            $this->promotionService,
            $this->translator,
            $this->userFaker,
            $this->userKytManager,
            $this->userKytService,
            $this->userManager,
            $this->userRepository
        );

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $emailService = $this->getMockBuilder(EmailService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $userKytService = new UserKytService(
            $emailService,
            $this->paginator,
            $this->promotionService,
            $this->translator,
            $this->userKytManager,
            $this->userRepository
        );

        $this->assertInstanceOf(UserKytService::class, $userKytService);
    }

    public function testNurture(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $user
            ->setIsEnabled(true)
            ->setIsVerified(true);
        $this->userManager->save($user);

        $userKytService = $this->userKytService->nurture();
        $this->assertInstanceOf(UserKytService::class, $userKytService);
    }

    public function testNurtureUserKyt(): void
    {
        $this->purge();
        $user = $this->userFaker->createUserPersisted();

        $user = $this->userKytService->nurtureUserKyt($user);
        $this->assertInstanceOf(User::class, $user);
        $this->assertTrue($user->getUserKyt()->getBasicConfigurationSent());
        $this->assertFalse(null === $user->getUserKyt()->getDateOfLastMessage());

        $user = $this->userKytService->nurtureUserKyt($user);
        $this->assertInstanceOf(User::class, $user);
        $this->assertTrue($user->getUserKyt()->getRoutinesSent());
        $this->assertFalse(null === $user->getUserKyt()->getDateOfLastMessage());

        $user = $this->userKytService->nurtureUserKyt($user);
        $this->assertInstanceOf(User::class, $user);
        $this->assertTrue($user->getUserKyt()->getRemindersSent());
        $this->assertFalse(null === $user->getUserKyt()->getDateOfLastMessage());

        $user = $this->userKytService->nurtureUserKyt($user);
        $this->assertInstanceOf(User::class, $user);
        $this->assertTrue($user->getUserKyt()->getCompletingRoutinesSent());
        $this->assertFalse(null === $user->getUserKyt()->getDateOfLastMessage());

        $user = $this->userKytService->nurtureUserKyt($user);
        $this->assertInstanceOf(User::class, $user);
        $this->assertTrue($user->getUserKyt()->getNotesSent());
        $this->assertFalse(null === $user->getUserKyt()->getDateOfLastMessage());

        $user = $this->userKytService->nurtureUserKyt($user);
        $this->assertInstanceOf(User::class, $user);
        $this->assertTrue($user->getUserKyt()->getRewardsSent());
        $this->assertFalse(null === $user->getUserKyt()->getDateOfLastMessage());

        $user = $this->userKytService->nurtureUserKyt($user);
        $this->assertInstanceOf(User::class, $user);
        $this->assertTrue($user->getUserKyt()->getProjectsSent());
        $this->assertFalse(null === $user->getUserKyt()->getDateOfLastMessage());

        $user = $this->userKytService->nurtureUserKyt($user);
        $this->assertInstanceOf(User::class, $user);
        $this->assertTrue($user->getUserKyt()->getGoalsSent());
        $this->assertFalse(null === $user->getUserKyt()->getDateOfLastMessage());

        $user = $this->userKytService->nurtureUserKyt($user);
        $this->assertInstanceOf(User::class, $user);
        $this->assertFalse(null === $user->getUserKyt()->getDateOfLastMessage());
    }

    public function testRewardUserKyt(): void
    {
        $this->purge();
        $user = $this->userFaker->createUserPersisted();

        $used = $this->userKytService->rewardUserKyt($user->getUserKyt());
        $this->assertFalse($used);
    }
}
