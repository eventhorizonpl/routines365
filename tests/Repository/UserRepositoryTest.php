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
        unset($this->managerRegistry);
        unset($this->userFaker);
        unset($this->userRepository);

        parent::tearDown();
    }

    public function testConstruct()
    {
        $userRepository = new UserRepository($this->managerRegistry);

        $this->assertInstanceOf(UserRepository::class, $userRepository);
    }

    public function testFindByParametersForAdmin()
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

    public function testFindForKpi()
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

    public function testFindOneByEmail()
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

    public function testUpgradePassword()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $password1 = $user->getPassword();
        $this->userRepository->upgradePassword($user, 'new password');
        $this->assertFalse($password1 === $user->getPassword());
    }
}
