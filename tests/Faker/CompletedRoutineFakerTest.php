<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\CompletedRoutine;
use App\Factory\CompletedRoutineFactory;
use App\Faker\CompletedRoutineFaker;
use App\Tests\AbstractDoctrineTestCase;

/**
 * @internal
 * @coversNothing
 */
final class CompletedRoutineFakerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?CompletedRoutineFactory $completedRoutineFactory;
    /**
     * @inject
     */
    private ?CompletedRoutineFaker $completedRoutineFaker;

    protected function tearDown(): void
    {
        $this->completedRoutineFactory = null;
        $this->completedRoutineFaker = null
        ;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $completedRoutineFaker = new CompletedRoutineFaker($this->completedRoutineFactory);

        $this->assertInstanceOf(CompletedRoutineFaker::class, $completedRoutineFaker);
    }

    public function testCreateCompletedRoutine(): void
    {
        $this->purge();
        $completedRoutine = $this->completedRoutineFaker->createCompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine);
        $comment = 'test comment';
        $minutesDevoted = 1;
        $completedRoutine = $this->completedRoutineFaker->createCompletedRoutine(
            $comment,
            $minutesDevoted
        );
        $this->assertSame($comment, $completedRoutine->getComment());
        $this->assertSame($minutesDevoted, $completedRoutine->getMinutesDevoted());
    }
}
