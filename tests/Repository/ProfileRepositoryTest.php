<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Repository\ProfileRepository;
use App\Tests\AbstractDoctrineTestCase;
use Doctrine\Persistence\ManagerRegistry;

final class ProfileRepositoryTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?ManagerRegistry $managerRegistry;
    /**
     * @inject
     */
    private ?ProfileRepository $profileRepository;

    protected function tearDown(): void
    {
        unset(
            $this->managerRegistry,
            $this->profileRepository
        );

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $profileRepository = new ProfileRepository($this->managerRegistry);

        $this->assertInstanceOf(ProfileRepository::class, $profileRepository);
    }
}
