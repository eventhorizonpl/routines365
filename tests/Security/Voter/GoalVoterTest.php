<?php

declare(strict_types=1);

namespace App\Tests\Security\Voter;

use App\Faker\{GoalFaker, UserFaker};
use App\Security\Voter\GoalVoter;
use App\Tests\AbstractDoctrineTestCase;
use ReflectionMethod;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;

/**
 * @internal
 * @coversNothing
 */
final class GoalVoterTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?GoalFaker $goalFaker;
    /**
     * @inject
     */
    private ?GoalVoter $goalVoter;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        $this->goalFaker = null;
        $this->goalVoter = null;
        $this->userFaker = null
        ;

        parent::tearDown();
    }

    public function testSupports(): void
    {
        $goal = $this->goalFaker->createGoal();

        $method = new ReflectionMethod(GoalVoter::class, 'supports');
        $method->setAccessible(true);
        $goalVoter = new GoalVoter();

        $this->assertTrue($method->invoke($goalVoter, GoalVoter::DELETE, $goal));
        $this->assertTrue($method->invoke($goalVoter, GoalVoter::EDIT, $goal));
    }

    public function testVoteOnAttribute(): void
    {
        $goal1 = $this->goalFaker->createGoal();
        $user1 = $this->userFaker->createUser();
        $goal1->setUser($user1);
        $token1 = new AnonymousToken('test', $user1);
        $user2 = $this->userFaker->createUser();
        $token2 = new AnonymousToken('test', $user2);

        $method = new ReflectionMethod(GoalVoter::class, 'voteOnAttribute');
        $method->setAccessible(true);
        $goalVoter = new GoalVoter();

        $this->assertTrue($method->invoke($goalVoter, GoalVoter::DELETE, $goal1, $token1));
        $this->assertTrue($method->invoke($goalVoter, GoalVoter::EDIT, $goal1, $token1));
        $this->assertFalse($method->invoke($goalVoter, 'WRONG', $goal1, $token1));
        $this->assertFalse($method->invoke($goalVoter, GoalVoter::DELETE, $goal1, $token2));
        $this->assertFalse($method->invoke($goalVoter, GoalVoter::EDIT, $goal1, $token2));
    }
}
