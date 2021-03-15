<?php

declare(strict_types=1);

namespace App\Tests\Security\Voter;

use App\Faker\NoteFaker;
use App\Faker\UserFaker;
use App\Security\Voter\NoteVoter;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;
use ReflectionMethod;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;

/**
 * @internal
 * @coversNothing
 */
final class NoteVoterTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?NoteFaker $noteFaker;
    /**
     * @inject
     */
    private ?NoteVoter $noteVoter;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        $this->noteFaker = null;
        $this->noteVoter = null;
        $this->userFaker = null
        ;

        parent::tearDown();
    }

    public function testSupports(): void
    {
        $note = $this->noteFaker->createNote();

        $method = new ReflectionMethod(NoteVoter::class, 'supports');
        $method->setAccessible(true);
        $noteVoter = new NoteVoter();

        $this->assertTrue($method->invoke($noteVoter, NoteVoter::DELETE, $note));
        $this->assertTrue($method->invoke($noteVoter, NoteVoter::EDIT, $note));
        $this->assertTrue($method->invoke($noteVoter, NoteVoter::VIEW, $note));
    }

    public function testVoteOnAttribute(): void
    {
        $note1 = $this->noteFaker->createNote();
        $user1 = $this->userFaker->createUser();
        $note1->setUser($user1);
        $token1 = new AnonymousToken('test', $user1);
        $user2 = $this->userFaker->createUser();
        $token2 = new AnonymousToken('test', $user2);

        $method = new ReflectionMethod(NoteVoter::class, 'voteOnAttribute');
        $method->setAccessible(true);
        $noteVoter = new NoteVoter();

        $this->assertTrue($method->invoke($noteVoter, NoteVoter::DELETE, $note1, $token1));
        $this->assertTrue($method->invoke($noteVoter, NoteVoter::EDIT, $note1, $token1));
        $this->assertTrue($method->invoke($noteVoter, NoteVoter::VIEW, $note1, $token1));
        $note1->setDeletedAt(new DateTimeImmutable());
        $this->assertFalse($method->invoke($noteVoter, NoteVoter::VIEW, $note1, $token1));
        $this->assertFalse($method->invoke($noteVoter, 'WRONG', $note1, $token1));
        $this->assertFalse($method->invoke($noteVoter, NoteVoter::DELETE, $note1, $token2));
        $this->assertFalse($method->invoke($noteVoter, NoteVoter::EDIT, $note1, $token2));
        $this->assertFalse($method->invoke($noteVoter, NoteVoter::VIEW, $note1, $token2));
    }
}
