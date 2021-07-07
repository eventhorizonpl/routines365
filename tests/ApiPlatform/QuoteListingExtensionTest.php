<?php

declare(strict_types=1);

namespace App\Tests\ApiPlatform;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGenerator;
use App\ApiPlatform\QuoteListingExtension;
use App\Entity\{Quote, User};
use App\Faker\{QuoteFaker, UserFaker};
use App\Repository\QuoteRepository;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\Security\Core\Security;

/**
 * @internal
 */
final class QuoteListingExtensionTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?QuoteFaker $quoteFaker;
    /**
     * @inject
     */
    private ?QuoteListingExtension $quoteListingExtension;
    /**
     * @inject
     */
    private ?QuoteRepository $quoteRepository;
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
        $this->quoteFaker = null;
        $this->quoteListingExtension = null;
        $this->quoteRepository = null;
        $this->userFaker = null;
        $this->security = null;

        parent::tearDown();
    }

    public function createQuote(): Quote
    {
        return $this->quoteFaker->createQuotePersisted();
    }

    public function createUser(): User
    {
        return $this->userFaker->createRichUserPersisted();
    }

    public function testConstruct(): void
    {
        $quoteListingExtension = new QuoteListingExtension($this->security);

        $this->assertInstanceOf(QuoteListingExtension::class, $quoteListingExtension);
    }

    public function testApplyToCollection(): void
    {
        $this->purge();
        $quote = $this->createQuote();
        $user = $this->createUser();

        $queryBuilder = $this->quoteRepository->createQueryBuilder('q');
        $queryNameGenerator = new QueryNameGenerator();

        $this->assertNull($this->quoteListingExtension->applyToCollection($queryBuilder, $queryNameGenerator, Quote::class));
        $this->assertNull($this->quoteListingExtension->applyToCollection($queryBuilder, $queryNameGenerator, User::class));
    }
}
