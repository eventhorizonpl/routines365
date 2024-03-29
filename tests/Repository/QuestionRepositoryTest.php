<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Repository\QuestionRepository;
use App\Tests\AbstractDoctrineTestCase;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @internal
 */
final class QuestionRepositoryTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?ManagerRegistry $managerRegistry;

    protected function tearDown(): void
    {
        $this->managerRegistry = null
        ;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $questionnaireRepository = new QuestionRepository($this->managerRegistry);

        $this->assertInstanceOf(QuestionRepository::class, $questionnaireRepository);
    }
}
