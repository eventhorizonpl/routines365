<?php

declare(strict_types=1);

namespace App\Tests\Security\Voter;

use App\Faker\{RoutineFaker, UserFaker};
use App\Security\Voter\RoutineVoter;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;
use ReflectionMethod;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;

/**
 * @internal
 * @coversNothing
 */
final class RoutineVoterTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?RoutineFaker $routineFaker;
    /**
     * @inject
     */
    private ?RoutineVoter $routineVoter;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        $this->routineFaker = null;
        $this->routineVoter = null;
        $this->userFaker = null
        ;

        parent::tearDown();
    }

    public function testSupports(): void
    {
        $routine = $this->routineFaker->createRoutine();

        $method = new ReflectionMethod(RoutineVoter::class, 'supports');
        $method->setAccessible(true);
        $routineVoter = new RoutineVoter();

        $this->assertTrue($method->invoke($routineVoter, RoutineVoter::DELETE, $routine));
        $this->assertTrue($method->invoke($routineVoter, RoutineVoter::EDIT, $routine));
        $this->assertTrue($method->invoke($routineVoter, RoutineVoter::VIEW, $routine));
    }

    public function testVoteOnAttribute(): void
    {
        $routine1 = $this->routineFaker->createRoutine();
        $user1 = $this->userFaker->createUser();
        $routine1->setUser($user1);
        $token1 = new AnonymousToken('test', $user1);
        $user2 = $this->userFaker->createUser();
        $token2 = new AnonymousToken('test', $user2);

        $method = new ReflectionMethod(RoutineVoter::class, 'voteOnAttribute');
        $method->setAccessible(true);
        $routineVoter = new RoutineVoter();

        $this->assertTrue($method->invoke($routineVoter, RoutineVoter::DELETE, $routine1, $token1));
        $this->assertTrue($method->invoke($routineVoter, RoutineVoter::EDIT, $routine1, $token1));
        $this->assertTrue($method->invoke($routineVoter, RoutineVoter::VIEW, $routine1, $token1));
        $routine1->setDeletedAt(new DateTimeImmutable());
        $this->assertFalse($method->invoke($routineVoter, RoutineVoter::VIEW, $routine1, $token1));
        $this->assertFalse($method->invoke($routineVoter, 'WRONG', $routine1, $token1));
        $this->assertFalse($method->invoke($routineVoter, RoutineVoter::DELETE, $routine1, $token2));
        $this->assertFalse($method->invoke($routineVoter, RoutineVoter::EDIT, $routine1, $token2));
        $this->assertFalse($method->invoke($routineVoter, RoutineVoter::VIEW, $routine1, $token2));
    }
}
