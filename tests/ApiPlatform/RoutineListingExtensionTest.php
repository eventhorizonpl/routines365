<?php

declare(strict_types=1);

namespace App\Tests\ApiPlatform;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGenerator;
use App\ApiPlatform\RoutineListingExtension;
use App\Entity\{Routine, User};
use App\Faker\UserFaker;
use App\Repository\RoutineRepository;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\Security\Core\Security;

/**
 * @internal
 */
final class RoutineListingExtensionTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?RoutineRepository $routineRepository;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;
    /**
     * @inject
     */
    private ?Security $security;

    protected function tearDown(): void
    {
        $this->routineRepository = null;
        $this->userFaker = null;
        $this->security = null;

        parent::tearDown();
    }

    public function createRoutine(): Routine
    {
        $user = $this->userFaker->createRichUserPersisted();

        return $user->getRoutines()->first();
    }

    public function testConstruct(): void
    {
        $routineListingExtension = new RoutineListingExtension($this->security);

        $this->assertInstanceOf(RoutineListingExtension::class, $routineListingExtension);
    }

    public function testApplyToCollection(): void
    {
        $this->purge();
        $routine = $this->createRoutine();
        $user = $routine->getUser();

        $queryBuilder = $this->routineRepository->createQueryBuilder('r');
        $queryNameGenerator = new QueryNameGenerator();
        $security = $this->createStub(Security::class);
        $security->method('getUser')
            ->willReturn($user)
        ;

        $routineListingExtension = new RoutineListingExtension($security);

        $this->assertNull($routineListingExtension->applyToCollection($queryBuilder, $queryNameGenerator, Routine::class));
        $this->assertNull($routineListingExtension->applyToCollection($queryBuilder, $queryNameGenerator, User::class));
    }
}
