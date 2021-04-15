<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Repository\AccountRepository;
use App\Tests\AbstractDoctrineTestCase;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @internal
 */
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
        $this->accountRepository = null;
        $this->managerRegistry = null
        ;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $accountRepository = new AccountRepository($this->managerRegistry);

        $this->assertInstanceOf(AccountRepository::class, $accountRepository);
    }
}
