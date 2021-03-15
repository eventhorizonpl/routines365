<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Entity\Quote;
use App\Exception\ManagerException;
use App\Faker\QuoteFaker;
use App\Faker\UserFaker;
use App\Manager\QuoteManager;
use App\Repository\QuoteRepository;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @internal
 * @coversNothing
 */
final class QuoteManagerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?QuoteFaker $quoteFaker;
    /**
     * @inject
     */
    private ?QuoteManager $quoteManager;
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
    private ?ValidatorInterface $validator;

    protected function tearDown(): void
    {
        $this->quoteFaker = null;
        $this->quoteManager = null;
        $this->quoteRepository = null;
        $this->userFaker = null;
        $this->validator = null
        ;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $quoteManager = new QuoteManager($this->entityManager, $this->validator);

        $this->assertInstanceOf(QuoteManager::class, $quoteManager);
    }

    public function testBulkSave(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $popularity = 987;
        $quote = $this->quoteFaker->createQuotePersisted();
        $quote->setPopularity($popularity);
        $quoteId = $quote->getId();
        $quotes = [];
        $quotes[] = $quote;

        $quoteManager = $this->quoteManager->bulkSave($quotes, (string) $user, 1);
        $this->assertInstanceOf(QuoteManager::class, $quoteManager);

        $quote2 = $this->quoteRepository->findOneById($quoteId);
        $this->assertInstanceOf(Quote::class, $quote2);
        $this->assertSame($popularity, $quote2->getPopularity());
    }

    public function testDelete(): void
    {
        $this->purge();
        $quote = $this->quoteFaker->createQuotePersisted();
        $quoteId = $quote->getId();

        $quoteManager = $this->quoteManager->delete($quote);
        $this->assertInstanceOf(QuoteManager::class, $quoteManager);

        $quote2 = $this->quoteRepository->findOneById($quoteId);
        $this->assertNull($quote2);
    }

    public function testIncrementPopularity(): void
    {
        $this->purge();
        $quote = $this->quoteFaker->createQuotePersisted();
        $popularity = $quote->getPopularity();
        $quoteId = $quote->getId();

        $quoteManager = $this->quoteManager->incrementPopularity($quote);
        $this->assertInstanceOf(QuoteManager::class, $quoteManager);

        $quote2 = $this->quoteRepository->findOneById($quoteId);
        $this->assertInstanceOf(Quote::class, $quote2);
        $this->assertSame(($popularity + 1), $quote2->getPopularity());
    }

    public function testSave(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $quote = $this->quoteFaker->createQuotePersisted();

        $quoteManager = $this->quoteManager->save($quote, (string) $user, true);
        $this->assertInstanceOf(QuoteManager::class, $quoteManager);
    }

    public function testSaveException(): void
    {
        $this->expectException(ManagerException::class);
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $quote = $this->quoteFaker->createQuotePersisted();
        $quote->setPopularity(-1);

        $quoteManager = $this->quoteManager->save($quote, (string) $user, true);
    }

    public function testSoftDelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $quote = $this->quoteFaker->createQuotePersisted();
        $quoteId = $quote->getId();

        $quoteManager = $this->quoteManager->softDelete($quote, (string) $user);
        $this->assertInstanceOf(QuoteManager::class, $quoteManager);

        $quote2 = $this->quoteRepository->findOneById($quoteId);
        $this->assertInstanceOf(Quote::class, $quote2);
        $this->assertTrue(null !== $quote2->getDeletedAt());
    }

    public function testUndelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $quote = $this->quoteFaker->createQuotePersisted();
        $quoteId = $quote->getId();

        $quoteManager = $this->quoteManager->softDelete($quote, (string) $user);
        $this->assertInstanceOf(QuoteManager::class, $quoteManager);

        $quote2 = $this->quoteRepository->findOneById($quoteId);
        $this->assertInstanceOf(Quote::class, $quote2);
        $this->assertTrue(null !== $quote2->getDeletedAt());

        $quoteManager = $this->quoteManager->undelete($quote);
        $this->assertInstanceOf(QuoteManager::class, $quoteManager);

        $quote3 = $this->quoteRepository->findOneById($quoteId);
        $this->assertInstanceOf(Quote::class, $quote3);
        $this->assertTrue(null === $quote3->getDeletedAt());
    }

    public function testValidate(): void
    {
        $this->purge();
        $quote = $this->quoteFaker->createQuotePersisted();

        $errors = $this->quoteManager->validate($quote);
        $this->assertCount(0, $errors);

        $quote->setPopularity(-1);
        $errors = $this->quoteManager->validate($quote);
        $this->assertCount(1, $errors);
    }
}
