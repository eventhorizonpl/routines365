<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Repository\AccountRepository;
use App\Tests\AbstractDoctrineTestCase;
use Doctrine\Persistence\ManagerRegistry;

final class AccountRepositoryTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?AccountRepository $accountRepository;
    /**
     * @inject
     */
    private ?ManagerRegistry $managerRegistry;

    protected function tearDown(): void
    {
        unset($this->accountRepository);
        unset($this->managerRegistry);

        parent::tearDown();
    }

    public function testConstruct()
    {
        $accountRepository = new AccountRepository($this->managerRegistry);

        $this->assertInstanceOf(AccountRepository::class, $accountRepository);
    }
}
