<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Faker\UserFaker;
use App\Repository\AccountOperationRepository;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;

final class AccountOperationRepositoryTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?AccountOperationRepository $accountOperationRepository;
    /**
     * @inject
     */
    private ?ManagerRegistry $managerRegistry;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        unset($this->accountOperationRepository);
        unset($this->managerRegistry);
        unset($this->userFaker);

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $accountOperationRepository = new AccountOperationRepository($this->managerRegistry);

        $this->assertInstanceOf(AccountOperationRepository::class, $accountOperationRepository);
    }

    public function testFindByParametersForAdmin(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $accountOperations = $this->accountOperationRepository->findByParametersForAdmin()->getResult();
        $this->assertCount(1, $accountOperations);
        $this->assertIsArray($accountOperations);

        $parameters = [
            'type' => 'wrong',
        ];
        $accountOperations = $this->accountOperationRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $accountOperations);
        $this->assertIsArray($accountOperations);

        $parameters = [
            'query' => $user->getEmail(),
        ];
        $accountOperations = $this->accountOperationRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $accountOperations);
        $this->assertIsArray($accountOperations);

        $parameters = [
            'query' => 'wrong email',
        ];
        $accountOperations = $this->accountOperationRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $accountOperations);
        $this->assertIsArray($accountOperations);

        $parameters = [
            'ends_at' => new DateTimeImmutable('NOW'),
        ];
        $accountOperations = $this->accountOperationRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $accountOperations);
        $this->assertIsArray($accountOperations);

        $parameters = [
            'starts_at' => new DateTimeImmutable('+1 minute'),
        ];
        $accountOperations = $this->accountOperationRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $accountOperations);
        $this->assertIsArray($accountOperations);
    }

    public function testFindByParametersForFrontend(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $accountOperation = $user->getAccount()->getAccountOperations()->first();

        $accountOperations = $this->accountOperationRepository->findByParametersForFrontend($user)->getResult();
        $this->assertCount(1, $accountOperations);
        $this->assertIsArray($accountOperations);

        $parameters = [
            'type' => 'wrong',
        ];
        $accountOperations = $this->accountOperationRepository->findByParametersForFrontend($user, $parameters)->getResult();
        $this->assertCount(0, $accountOperations);
        $this->assertIsArray($accountOperations);

        $parameters = [
            'query' => $accountOperation->getDescription(),
        ];
        $accountOperations = $this->accountOperationRepository->findByParametersForFrontend($user, $parameters)->getResult();
        $this->assertCount(1, $accountOperations);
        $this->assertIsArray($accountOperations);

        $parameters = [
            'query' => 'wrong email',
        ];
        $accountOperations = $this->accountOperationRepository->findByParametersForFrontend($user, $parameters)->getResult();
        $this->assertCount(0, $accountOperations);
        $this->assertIsArray($accountOperations);
    }
}
