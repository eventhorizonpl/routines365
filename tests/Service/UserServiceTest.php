<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\User;
use App\Enum\UserTypeEnum;
use App\Faker\UserFaker;
use App\Manager\UserManager;
use App\Repository\UserRepository;
use App\Service\{PromotionService, UserService};
use App\Tests\AbstractDoctrineTestCase;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @internal
 */
final class UserServiceTest extends AbstractDoctrineTestCase
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
    private ?UserFaker $userFaker;
    /**
     * @inject
     */
    private ?UserManager $userManager;
    /**
     * @inject
     */
    private ?UserPasswordEncoderInterface $userPasswordEncoder;
    /**
     * @inject
     */
    private ?UserRepository $userRepository;
    /**
     * @inject
     */
    private ?UserService $userService;

    protected function tearDown(): void
    {
        $this->paginator = null;
        $this->promotionService = null;
        $this->userFaker = null;
        $this->userManager = null;
        $this->userPasswordEncoder = null;
        $this->userRepository = null;
        $this->userService = null
        ;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $userService = new UserService(
            $this->paginator,
            $this->promotionService,
            $this->userManager,
            $this->userPasswordEncoder,
            $this->userRepository
        );

        $this->assertInstanceOf(UserService::class, $userService);
    }

    public function testEncodePassword(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $oldPassword = $user->getPassword();

        $user = $this->userService->encodePassword(
            $user,
            'new test password'
        );

        $this->assertInstanceOf(User::class, $user);
        $this->assertFalse($user->getPassword() === $oldPassword);
    }

    public function testChangeTypeToCustomer(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $user = $this->userService->changeTypeToCustomer($user);

        $this->assertInstanceOf(User::class, $user);
        $this->assertSame(UserTypeEnum::CUSTOMER, $user->getType());
    }

    public function testChangeTypeToProspect(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $user = $this->userService->changeTypeToProspect($user);

        $this->assertInstanceOf(User::class, $user);
        $this->assertSame(UserTypeEnum::PROSPECT, $user->getType());
    }

    public function testOnAuthenticationSuccess(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $oldLastLoginAt = $user->getLastLoginAt();

        $user = $this->userService->onAuthenticationSuccess($user);

        $this->assertInstanceOf(User::class, $user);
        $this->assertFalse($user->getLastLoginAt() === $oldLastLoginAt);
    }

    public function testRewardUserActivity(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $this->assertInstanceOf(UserService::class, $this->userService->rewardUserActivity());
    }
}
