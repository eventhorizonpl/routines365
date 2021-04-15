<?php

declare(strict_types=1);

namespace App\Tests\Security\Voter;

use App\Faker\{ReminderFaker, UserFaker};
use App\Security\Voter\ReminderVoter;
use App\Tests\AbstractDoctrineTestCase;
use ReflectionMethod;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;

/**
 * @internal
 * @coversNothing
 */
final class ReminderVoterTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?ReminderFaker $reminderFaker;
    /**
     * @inject
     */
    private ?ReminderVoter $reminderVoter;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        $this->reminderFaker = null;
        $this->reminderVoter = null;
        $this->userFaker = null
        ;

        parent::tearDown();
    }

    public function testSupports(): void
    {
        $reminder = $this->reminderFaker->createReminder();

        $method = new ReflectionMethod(ReminderVoter::class, 'supports');
        $method->setAccessible(true);
        $reminderVoter = new ReminderVoter();

        $this->assertTrue($method->invoke($reminderVoter, ReminderVoter::DELETE, $reminder));
        $this->assertTrue($method->invoke($reminderVoter, ReminderVoter::EDIT, $reminder));
    }

    public function testVoteOnAttribute(): void
    {
        $reminder1 = $this->reminderFaker->createReminder();
        $user1 = $this->userFaker->createUser();
        $reminder1->setUser($user1);
        $token1 = new AnonymousToken('test', $user1);
        $user2 = $this->userFaker->createUser();
        $token2 = new AnonymousToken('test', $user2);

        $method = new ReflectionMethod(ReminderVoter::class, 'voteOnAttribute');
        $method->setAccessible(true);
        $reminderVoter = new ReminderVoter();

        $this->assertTrue($method->invoke($reminderVoter, ReminderVoter::DELETE, $reminder1, $token1));
        $this->assertTrue($method->invoke($reminderVoter, ReminderVoter::EDIT, $reminder1, $token1));
        $this->assertFalse($method->invoke($reminderVoter, 'WRONG', $reminder1, $token1));
        $this->assertFalse($method->invoke($reminderVoter, ReminderVoter::DELETE, $reminder1, $token2));
        $this->assertFalse($method->invoke($reminderVoter, ReminderVoter::EDIT, $reminder1, $token2));
    }
}
