<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\CompletedRoutine;
use App\Factory\CompletedRoutineFactory;
use App\Faker\CompletedRoutineFaker;
use App\Tests\AbstractDoctrineTestCase;

class CompletedRoutineFakerTest extends AbstractDoctrineTestCase
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
        unset($this->completedRoutineFactory);
        unset($this->completedRoutineFaker);

        parent::tearDown();
    }

    public function testConstruct()
    {
        $completedRoutineFaker = new CompletedRoutineFaker($this->completedRoutineFactory);

        $this->assertInstanceOf(CompletedRoutineFaker::class, $completedRoutineFaker);
    }

    public function testCreateCompletedRoutine()
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
        $this->assertEquals($comment, $completedRoutine->getComment());
        $this->assertEquals($minutesDevoted, $completedRoutine->getMinutesDevoted());
    }
}
