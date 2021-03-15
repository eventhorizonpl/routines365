<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Repository\ProfileRepository;
use App\Tests\AbstractDoctrineTestCase;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @internal
 * @coversNothing
 */
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
        $this->managerRegistry = null;
        $this->profileRepository = null
        ;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $profileRepository = new ProfileRepository($this->managerRegistry);

        $this->assertInstanceOf(ProfileRepository::class, $profileRepository);
    }
}
