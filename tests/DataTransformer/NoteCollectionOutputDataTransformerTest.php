<?php

declare(strict_types=1);

namespace App\Tests\DataTransformer;

use App\DataTransformer\NoteCollectionOutputDataTransformer;
use App\Dto\NoteCollectionOutput;
use App\Entity\Note;
use App\Faker\UserFaker;
use App\Tests\AbstractDoctrineTestCase;

/**
 * @internal
 */
final class NoteCollectionOutputDataTransformerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?NoteCollectionOutputDataTransformer $noteCollectionOutputDataTransformer;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        $this->noteCollectionOutputDataTransformer = null;
        $this->userFaker = null;

        parent::tearDown();
    }

    public function createNote(): Note
    {
        $user = $this->userFaker->createRichUserPersisted();

        return $user->getNotes()->first();
    }

    public function testSupportsTransformation(): void
    {
        $this->purge();
        $note = $this->createNote();

        $this->assertFalse($this->noteCollectionOutputDataTransformer->supportsTransformation($note, Note::class));
        $this->assertTrue($this->noteCollectionOutputDataTransformer->supportsTransformation($note, NoteCollectionOutput::class));
    }

    public function testTransform(): void
    {
        $this->purge();
        $note = $this->createNote();

        $noteCollectionOutput = $this->noteCollectionOutputDataTransformer->transform($note, NoteCollectionOutput::class);
        $this->assertInstanceOf(NoteCollectionOutput::class, $noteCollectionOutput);
        $this->assertSame($note->getContent(), $noteCollectionOutput->content);
        $this->assertSame($note->getRoutine()->getUuid(), $noteCollectionOutput->routine);
        $this->assertSame($note->getTitle(), $noteCollectionOutput->title);
    }
}
