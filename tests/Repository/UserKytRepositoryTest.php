<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Repository\UserKytRepository;
use App\Tests\AbstractDoctrineTestCase;
use Doctrine\Persistence\ManagerRegistry;

final class UserKytRepositoryTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?ManagerRegistry $managerRegistry;

    protected function tearDown(): void
    {
        unset(
            $this->managerRegistry,
        );

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $userKytRepository = new UserKytRepository($this->managerRegistry);

        $this->assertInstanceOf(UserKytRepository::class, $userKytRepository);
    }
}
