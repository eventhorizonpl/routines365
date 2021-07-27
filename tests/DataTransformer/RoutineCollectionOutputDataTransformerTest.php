<?php

declare(strict_types=1);

namespace App\Tests\DataTransformer;

use App\DataTransformer\RoutineCollectionOutputDataTransformer;
use App\Dto\RoutineCollectionOutput;
use App\Entity\Routine;
use App\Faker\UserFaker;
use App\Tests\AbstractDoctrineTestCase;

/**
 * @internal
 */
final class RoutineCollectionOutputDataTransformerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?RoutineCollectionOutputDataTransformer $routineCollectionOutputDataTransformer;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        $this->routineCollectionOutputDataTransformer = null;
        $this->userFaker = null;

        parent::tearDown();
    }

    public function createRoutine(): Routine
    {
        $user = $this->userFaker->createRichUserPersisted();

        return $user->getRoutines()->first();
    }

    public function testSupportsTransformation(): void
    {
        $this->purge();
        $routine = $this->createRoutine();

        $this->assertFalse($this->routineCollectionOutputDataTransformer->supportsTransformation($routine, Routine::class));
        $this->assertTrue($this->routineCollectionOutputDataTransformer->supportsTransformation($routine, RoutineCollectionOutput::class));
    }

    public function testTransform(): void
    {
        $this->purge();
        $routine = $this->createRoutine();

        $routineCollectionOutput = $this->routineCollectionOutputDataTransformer->transform($routine, RoutineCollectionOutput::class);
        $this->assertInstanceOf(RoutineCollectionOutput::class, $routineCollectionOutput);
        $this->assertSame($routine->getUuid(), $routineCollectionOutput->uuid);
        $this->assertSame($routine->getCompletedRoutinesCount(), $routineCollectionOutput->completedRoutinesCount);
        $this->assertSame($routine->getCompletedRoutinesDevotedTime(), $routineCollectionOutput->completedRoutinesDevotedTime);
        $this->assertSame($routine->getCompletedRoutinesPercent(), $routineCollectionOutput->completedRoutinesPercent);
        $this->assertSame($routine->getDescription(), $routineCollectionOutput->description);
        $this->assertSame($routine->getGoalsCompletedCount(), $routineCollectionOutput->goalsCompletedCount);
        $this->assertSame($routine->getGoalsCompletedPercent(), $routineCollectionOutput->goalsCompletedPercent);
        $this->assertSame($routine->getGoalsCount(), $routineCollectionOutput->goalsCount);
        $this->assertSame($routine->getGoalsNotCompletedCount(), $routineCollectionOutput->goalsNotCompletedCount);
        $this->assertSame($routine->getGoalsNotCompletedPercent(), $routineCollectionOutput->goalsNotCompletedPercent);
        $this->assertSame($routine->getName(), $routineCollectionOutput->name);
        $this->assertSame($routine->getNotesCount(), $routineCollectionOutput->notesCount);
        $this->assertSame($routine->getRemindersCount(), $routineCollectionOutput->remindersCount);
        $this->assertSame($routine->getRewardsCount(), $routineCollectionOutput->rewardsCount);
        $this->assertSame($routine->getSentRemindersCount(), $routineCollectionOutput->sentRemindersCount);
        $this->assertSame($routine->getSentRemindersPercent(), $routineCollectionOutput->sentRemindersPercent);
    }
}
