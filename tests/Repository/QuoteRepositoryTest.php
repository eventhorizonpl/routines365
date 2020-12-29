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
        unset(
            $this->managerRegistry,
            $this->quoteFaker,
            $this->quoteRepository
        );

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $quoteRepository = new QuoteRepository($this->managerRegistry);

        $this->assertInstanceOf(QuoteRepository::class, $quoteRepository);
    }

    public function testFindByParametersForAdmin(): void
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

    public function testFindByParametersForFrontend(): void
    {
        $this->purge();
        $quote = $this->quoteFaker->createQuotePersisted();

        $quotes = $this->quoteRepository->findByParametersForFrontend()->getResult();
        if (true === $quote->getIsVisible()) {
            $this->assertCount(1, $quotes);
        } else {
            $this->assertCount(0, $quotes);
        }
        $this->assertIsArray($quotes);

        $parameters = [
            'query' => $quote->getAuthor(),
        ];
        $quotes = $this->quoteRepository->findByParametersForFrontend($parameters)->getResult();
        if (true === $quote->getIsVisible()) {
            $this->assertCount(1, $quotes);
        } else {
            $this->assertCount(0, $quotes);
        }
        $this->assertIsArray($quotes);

        $parameters = [
            'query' => 'wrong email',
        ];
        $quotes = $this->quoteRepository->findByParametersForFrontend($parameters)->getResult();
        $this->assertCount(0, $quotes);
        $this->assertIsArray($quotes);
    }

    public function testFindOneByStringLength(): void
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
