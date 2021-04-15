<?php

declare(strict_types=1);

namespace App\Tests\Security\Voter;

use App\Faker\{RewardFaker, UserFaker};
use App\Security\Voter\RewardVoter;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;
use ReflectionMethod;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;

/**
 * @internal
 * @coversNothing
 */
final class RewardVoterTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?RewardFaker $rewardFaker;
    /**
     * @inject
     */
    private ?RewardVoter $rewardVoter;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        $this->rewardFaker = null;
        $this->rewardVoter = null;
        $this->userFaker = null
        ;

        parent::tearDown();
    }

    public function testSupports(): void
    {
        $reward = $this->rewardFaker->createReward();

        $method = new ReflectionMethod(RewardVoter::class, 'supports');
        $method->setAccessible(true);
        $rewardVoter = new RewardVoter();

        $this->assertTrue($method->invoke($rewardVoter, RewardVoter::DELETE, $reward));
        $this->assertTrue($method->invoke($rewardVoter, RewardVoter::EDIT, $reward));
        $this->assertTrue($method->invoke($rewardVoter, RewardVoter::VIEW, $reward));
    }

    public function testVoteOnAttribute(): void
    {
        $reward1 = $this->rewardFaker->createReward();
        $user1 = $this->userFaker->createUser();
        $reward1->setUser($user1);
        $token1 = new AnonymousToken('test', $user1);
        $user2 = $this->userFaker->createUser();
        $token2 = new AnonymousToken('test', $user2);

        $method = new ReflectionMethod(RewardVoter::class, 'voteOnAttribute');
        $method->setAccessible(true);
        $rewardVoter = new RewardVoter();

        $this->assertTrue($method->invoke($rewardVoter, RewardVoter::DELETE, $reward1, $token1));
        $this->assertTrue($method->invoke($rewardVoter, RewardVoter::EDIT, $reward1, $token1));
        $this->assertTrue($method->invoke($rewardVoter, RewardVoter::VIEW, $reward1, $token1));
        $reward1->setDeletedAt(new DateTimeImmutable());
        $this->assertFalse($method->invoke($rewardVoter, RewardVoter::VIEW, $reward1, $token1));
        $this->assertFalse($method->invoke($rewardVoter, 'WRONG', $reward1, $token1));
        $this->assertFalse($method->invoke($rewardVoter, RewardVoter::DELETE, $reward1, $token2));
        $this->assertFalse($method->invoke($rewardVoter, RewardVoter::EDIT, $reward1, $token2));
        $this->assertFalse($method->invoke($rewardVoter, RewardVoter::VIEW, $reward1, $token2));
    }
}
