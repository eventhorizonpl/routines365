<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\User;
use App\Faker\UserFaker;
use App\Manager\UserManager;
use App\Repository\UserRepository;
use App\Service\UserService;
use App\Tests\AbstractDoctrineTestCase;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class UserServiceTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?PaginatorInterface $paginator;
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
        unset(
            $this->paginator,
            $this->userFaker,
            $this->userManager,
            $this->userPasswordEncoder,
            $this->userRepository,
            $this->userService
        );

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $userService = new UserService(
            $this->paginator,
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
        $this->assertEquals(User::TYPE_CUSTOMER, $user->getType());
    }

    public function testChangeTypeToProspect(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $user = $this->userService->changeTypeToProspect($user);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals(User::TYPE_PROSPECT, $user->getType());
    }

    public function testOnAuthenticationSuccess(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $oldApiToken = $user->getApiToken();
        $oldLastLoginAt = $user->getLastLoginAt();

        $user = $this->userService->onAuthenticationSuccess($user);

        $this->assertInstanceOf(User::class, $user);
        $this->assertFalse($user->getApiToken() === $oldApiToken);
        $this->assertFalse($user->getLastLoginAt() === $oldLastLoginAt);
    }
}
