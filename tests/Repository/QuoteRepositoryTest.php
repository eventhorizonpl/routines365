<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Entity\Quote;
use App\Faker\QuoteFaker;
use App\Repository\QuoteRepository;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;

final class QuoteRepositoryTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?ManagerRegistry $managerRegistry;
    /**
     * @inject
     */
    private ?QuoteFaker $quoteFaker;
    /**
     * @inject
     */
    private ?QuoteRepository $quoteRepository;

    protected function tearDown(): void
    {
        unset($this->managerRegistry);
        unset($this->quoteFaker);
        unset($this->quoteRepository);

        parent::tearDown();
    }

    public function testConstruct()
    {
        $quoteRepository = new QuoteRepository($this->managerRegistry);

        $this->assertInstanceOf(QuoteRepository::class, $quoteRepository);
    }

    public function testFindByParametersForAdmin()
    {
        $this->purge();
        $quote = $this->quoteFaker->createQuotePersisted();

        $quotes = $this->quoteRepository->findByParametersForAdmin()->getResult();
        $this->assertCount(1, $quotes);
        $this->assertIsArray($quotes);

        $parameters = [
            'query' => $quote->getAuthor(),
        ];
        $quotes = $this->quoteRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $quotes);
        $this->assertIsArray($quotes);

        $parameters = [
            'query' => 'wrong email',
        ];
        $quotes = $this->quoteRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $quotes);
        $this->assertIsArray($quotes);

        $parameters = [
            'ends_at' => new DateTimeImmutable('NOW'),
        ];
        $quotes = $this->quoteRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $quotes);
        $this->assertIsArray($quotes);

        $parameters = [
            'starts_at' => new DateTimeImmutable('+1 minute'),
        ];
        $quotes = $this->quoteRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $quotes);
        $this->assertIsArray($quotes);
    }

    public function testFindOneByStringLength()
    {
        $this->purge();
        $quote = $this->quoteFaker->createQuotePersisted();

        $quote = $this->quoteRepository->findOneByStringLength();
        $this->assertInstanceOf(Quote::class, $quote);

        $quote = $this->quoteRepository->findOneByStringLength(300);
        $this->assertInstanceOf(Quote::class, $quote);

        $quote = $this->quoteRepository->findOneByStringLength(10);
        $this->assertEquals(null, $quote);
    }
}
