<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Repository\AnswerRepository;
use App\Tests\AbstractDoctrineTestCase;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @internal
 * @coversNothing
 */
final class AnswerRepositoryTest extends AbstractDoctrineTestCase
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
        $answerRepository = new AnswerRepository($this->managerRegistry);

        $this->assertInstanceOf(AnswerRepository::class, $answerRepository);
    }
}
