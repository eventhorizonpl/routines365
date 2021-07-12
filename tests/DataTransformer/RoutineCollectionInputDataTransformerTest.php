<?php

declare(strict_types=1);

namespace App\Tests\DataPersister;

use ApiPlatform\Core\Serializer\AbstractItemNormalizer;
use App\DataTransformer\RoutineCollectionInputDataTransformer;
use App\Entity\Routine;
use App\Factory\RoutineFactory;
use App\Faker\UserFaker;
use App\Repository\RoutineRepository;
use App\Tests\AbstractDoctrineTestCase;
use stdClass;
use Symfony\Component\Security\Core\Security;

/**
 * @internal
 */
final class RoutineCollectionInputDataTransformerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?RoutineCollectionInputDataTransformer $routineCollectionInputDataTransformer;
    /**
     * @inject
     */
    private ?RoutineFactory $routineFactory;
    /**
     * @inject
     */
    private ?RoutineRepository $routineRepository;
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
        $this->routineCollectionInputDataTransformer = null;
        $this->routineFactory = null;
        $this->routineRepository = null;
        $this->userFaker = null;
        $this->security = null;

        parent::tearDown();
    }

    public function createRoutine(): Routine
    {
        $user = $this->userFaker->createRichUserPersisted();

        return $user->getRoutines()->first();
    }

    public function convertRoutine(Routine $routine): stdClass
    {
        $stdClass = new stdClass();
        $stdClass->description = $routine->getDescription();
        $stdClass->isEnabled = $routine->getIsEnabled();
        $stdClass->name = $routine->getName();
        $stdClass->type = $routine->getType();

        return $stdClass;
    }

    public function testConstruct(): void
    {
        $routineCollectionInputDataTransformer = new RoutineCollectionInputDataTransformer(
            $this->routineFactory,
            $this->security
        );

        $this->assertInstanceOf(RoutineCollectionInputDataTransformer::class, $routineCollectionInputDataTransformer);
    }

    public function testSupportsTransformation(): void
    {
        $this->purge();
        $routine = $this->createRoutine();

        $context = [
            'input' => [
                'class' => Routine::class,
            ],
        ];

        $this->assertFalse($this->routineCollectionInputDataTransformer->supportsTransformation($routine, Routine::class));
        $this->assertTrue($this->routineCollectionInputDataTransformer->supportsTransformation((array) $routine, Routine::class, $context));
    }

    public function testTransform(): void
    {
        $this->purge();
        $routine = $this->createRoutine();
        $user = $routine->getUser();

        $security = $this->createStub(Security::class);
        $security->method('getUser')
            ->willReturn($user)
        ;

        $context = [
            AbstractItemNormalizer::OBJECT_TO_POPULATE => $routine,
        ];

        $routineCollectionInputDataTransformer = new RoutineCollectionInputDataTransformer(
            $this->routineFactory,
            $security
        );

        $routine2 = $routineCollectionInputDataTransformer->transform($this->convertRoutine($routine), Routine::class);
        $this->assertInstanceOf(Routine::class, $routine2);
        $this->assertSame($routine->getDescription(), $routine2->getDescription());
        $this->assertSame($routine->getIsEnabled(), $routine2->getIsEnabled());
        $this->assertSame($routine->getName(), $routine2->getName());
        $this->assertSame($routine->getType(), $routine2->getType());

        $routine3 = $routineCollectionInputDataTransformer->transform($this->convertRoutine($routine), Routine::class, $context);
        $this->assertInstanceOf(Routine::class, $routine3);
        $this->assertSame($routine->getDescription(), $routine3->getDescription());
        $this->assertSame($routine->getIsEnabled(), $routine3->getIsEnabled());
        $this->assertSame($routine->getName(), $routine3->getName());
        $this->assertSame($routine->getType(), $routine3->getType());
    }
}
