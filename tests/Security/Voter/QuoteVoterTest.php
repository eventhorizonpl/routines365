<?php

declare(strict_types=1);

namespace App\Tests\Security\Voter;

use App\Faker\{QuoteFaker, UserFaker};
use App\Security\Voter\QuoteVoter;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;
use ReflectionMethod;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;

/**
 * @internal
 */
final class QuoteVoterTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?QuoteFaker $quoteFaker;
    /**
     * @inject
     */
    private ?QuoteVoter $quoteVoter;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        $this->quoteFaker = null;
        $this->quoteVoter = null;
        $this->userFaker = null
        ;

        parent::tearDown();
    }

    public function testSupports(): void
    {
        $quote = $this->quoteFaker->createQuote();

        $method = new ReflectionMethod(QuoteVoter::class, 'supports');
        $method->setAccessible(true);
        $quoteVoter = new QuoteVoter();

        $this->assertTrue($method->invoke($quoteVoter, QuoteVoter::SEND, $quote));
    }

    public function testVoteOnAttribute(): void
    {
        $quote1 = $this->quoteFaker->createQuote();
        $quote1->setIsVisible(true);
        $user1 = $this->userFaker->createUser();
        $token1 = new AnonymousToken('test', $user1);

        $method = new ReflectionMethod(QuoteVoter::class, 'voteOnAttribute');
        $method->setAccessible(true);
        $quoteVoter = new QuoteVoter();

        $this->assertTrue($method->invoke($quoteVoter, QuoteVoter::SEND, $quote1, $token1));
        $quote1->setDeletedAt(new DateTimeImmutable());
        $this->assertFalse($method->invoke($quoteVoter, QuoteVoter::SEND, $quote1, $token1));
        $this->assertFalse($method->invoke($quoteVoter, 'WRONG', $quote1, $token1));
    }
}
