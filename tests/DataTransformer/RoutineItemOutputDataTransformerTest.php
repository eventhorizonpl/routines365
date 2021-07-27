<?php

declare(strict_types=1);

namespace App\Tests\DataTransformer;

use App\DataTransformer\RoutineItemOutputDataTransformer;
use App\Dto\RoutineItemOutput;
use App\Entity\Routine;
use App\Faker\UserFaker;
use App\Tests\AbstractDoctrineTestCase;

/**
 * @internal
 */
final class RoutineItemOutputDataTransformerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?RoutineItemOutputDataTransformer $routineItemOutputDataTransformer;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        $this->routineItemOutputDataTransformer = null;
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

        $this->assertFalse($this->routineItemOutputDataTransformer->supportsTransformation($routine, Routine::class));
        $this->assertTrue($this->routineItemOutputDataTransformer->supportsTransformation($routine, RoutineItemOutput::class));
    }

    public function testTransform(): void
    {
        $this->purge();
        $routine = $this->createRoutine();

        $routineItemOutput = $this->routineItemOutputDataTransformer->transform($routine, RoutineItemOutput::class);
        $this->assertInstanceOf(RoutineItemOutput::class, $routineItemOutput);
        $this->assertSame($routine->getUuid(), $routineItemOutput->uuid);
        $this->assertSame($routine->getDescription(), $routineItemOutput->description);
        $this->assertSame($routine->getName(), $routineItemOutput->name);
        $this->assertSame($routine->getType(), $routineItemOutput->type);
    }
}
