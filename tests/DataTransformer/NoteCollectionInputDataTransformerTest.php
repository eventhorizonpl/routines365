<?php

declare(strict_types=1);

namespace App\Tests\DataTransformer;

use ApiPlatform\Core\Serializer\AbstractItemNormalizer;
use App\DataTransformer\NoteCollectionInputDataTransformer;
use App\Entity\Note;
use App\Factory\NoteFactory;
use App\Faker\UserFaker;
use App\Repository\{NoteRepository, RoutineRepository};
use App\Tests\AbstractDoctrineTestCase;
use stdClass;
use Symfony\Component\Security\Core\Security;

/**
 * @internal
 */
final class NoteCollectionInputDataTransformerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?NoteCollectionInputDataTransformer $noteCollectionInputDataTransformer;
    /**
     * @inject
     */
    private ?NoteFactory $noteFactory;
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
        $this->noteCollectionInputDataTransformer = null;
        $this->noteFactory = null;
        $this->routineRepository = null;
        $this->userFaker = null;
        $this->security = null;

        parent::tearDown();
    }

    public function createNote(): Note
    {
        $user = $this->userFaker->createRichUserPersisted();

        return $user->getNotes()->first();
    }

    public function convertNote(Note $note): stdClass
    {
        $stdClass = new stdClass();
        $stdClass->content = $note->getContent();
        $stdClass->title = $note->getTitle();
        $stdClass->routine = $note->getRoutine()->getUuid();

        return $stdClass;
    }

    public function testConstruct(): void
    {
        $noteCollectionInputDataTransformer = new NoteCollectionInputDataTransformer(
            $this->noteFactory,
            $this->routineRepository,
            $this->security
        );

        $this->assertInstanceOf(NoteCollectionInputDataTransformer::class, $noteCollectionInputDataTransformer);
    }

    public function testSupportsTransformation(): void
    {
        $this->purge();
        $note = $this->createNote();

        $context = [
            'input' => [
                'class' => Note::class,
            ],
        ];

        $this->assertFalse($this->noteCollectionInputDataTransformer->supportsTransformation($note, Note::class));
        $this->assertTrue($this->noteCollectionInputDataTransformer->supportsTransformation((array) $note, Note::class, $context));
    }

    public function testTransform(): void
    {
        $this->purge();
        $note = $this->createNote();
        $user = $note->getUser();

        $security = $this->createStub(Security::class);
        $security->method('getUser')
            ->willReturn($user)
        ;

        $context = [
            AbstractItemNormalizer::OBJECT_TO_POPULATE => $note,
        ];

        $noteCollectionInputDataTransformer = new NoteCollectionInputDataTransformer(
            $this->noteFactory,
            $this->routineRepository,
            $security
        );

        $note2 = $noteCollectionInputDataTransformer->transform($this->convertNote($note), Note::class);
        $this->assertInstanceOf(Note::class, $note2);
        $this->assertSame($note->getContent(), $note2->getContent());
        $this->assertSame($note->getRoutine(), $note2->getRoutine());
        $this->assertSame($note->getTitle(), $note2->getTitle());

        $note3 = $noteCollectionInputDataTransformer->transform($this->convertNote($note), Note::class, $context);
        $this->assertInstanceOf(Note::class, $note3);
        $this->assertSame($note->getContent(), $note3->getContent());
        $this->assertSame($note->getRoutine(), $note3->getRoutine());
        $this->assertSame($note->getTitle(), $note3->getTitle());
    }
}
