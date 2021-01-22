<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Entity\User;
use App\Faker\UserFaker;
use App\Repository\UserRepository;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;

final class UserRepositoryTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?ManagerRegistry $managerRegistry;
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
        unset(
            $this->managerRegistry,
            $this->userFaker,
            $this->userRepository
        );

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $userRepository = new UserRepository($this->managerRegistry);

        $this->assertInstanceOf(UserRepository::class, $userRepository);
    }

    public function testFindByParametersForAdmin(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $users = $this->userRepository->findByParametersForAdmin()->getResult();
        $this->assertCount(1, $users);
        $this->assertIsArray($users);

        $parameters = [
            'type' => 'wrong',
        ];
        $users = $this->userRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $users);
        $this->assertIsArray($users);

        $parameters = [
            'query' => $user->getEmail(),
        ];
        $users = $this->userRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $users);
        $this->assertIsArray($users);

        $parameters = [
            'query' => 'wrong email',
        ];
        $users = $this->userRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $users);
        $this->assertIsArray($users);

        $parameters = [
            'ends_at' => new DateTimeImmutable('NOW'),
        ];
        $users = $this->userRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $users);
        $this->assertIsArray($users);

        $parameters = [
            'starts_at' => new DateTimeImmutable('+1 minute'),
        ];
        $users = $this->userRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $users);
        $this->assertIsArray($users);
    }

    public function testFindForKpi(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $users = $this->userRepository->findForKpi()->getResult();
        if ((true === $user->getIsEnabled()) && (true === $user->getIsVerified())) {
            $this->assertCount(1, $users);
        } else {
            $this->assertCount(0, $users);
        }
        $this->assertIsArray($users);
    }

    public function testFindForPostUserKytMessages(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $users = $this->userRepository->findForPostUserKytMessages()->getResult();
        if ((true === $user->getIsEnabled()) && (true === $user->getIsVerified())) {
            $this->assertCount(1, $users);
        } else {
            $this->assertCount(0, $users);
        }
        $this->assertIsArray($users);
    }

    public function testFindForRetention(): void
    {
        $startDate = new DateTimeImmutable();
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $endDate = new DateTimeImmutable();

        $users = $this->userRepository->findForRetention($endDate, $endDate, $startDate);
        $this->assertEquals(0, $users);
        $this->assertIsInt($users);
    }

    public function testFindForRetentionTotal(): void
    {
        $startDate = new DateTimeImmutable();
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $endDate = new DateTimeImmutable();

        $users = $this->userRepository->findForRetentionTotal($endDate, $startDate);
        $this->assertEquals(1, $users);
        $this->assertIsInt($users);
    }

    public function testFindOneByEmail(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $userResult = $this->userRepository->findOneByEmail($user->getEmail());
        if (true === $user->getIsEnabled()) {
            $this->assertInstanceOf(User::class, $userResult);
            $this->assertEquals($user, $userResult);
        } else {
            $this->assertEquals(null, $userResult);
        }
    }

    public function testUpgradePassword(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $password1 = $user->getPassword();
        $this->userRepository->upgradePassword($user, 'new password');
        $this->assertFalse($password1 === $user->getPassword());
    }
}
