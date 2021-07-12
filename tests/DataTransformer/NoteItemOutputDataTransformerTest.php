<?php

declare(strict_types=1);

namespace App\Tests\DataPersister;

use App\DataTransformer\NoteItemOutputDataTransformer;
use App\Dto\NoteItemOutput;
use App\Entity\Note;
use App\Faker\UserFaker;
use App\Tests\AbstractDoctrineTestCase;

/**
 * @internal
 */
final class NoteItemOutputDataTransformerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?NoteItemOutputDataTransformer $noteItemOutputDataTransformer;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        $this->noteItemOutputDataTransformer = null;
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

        $this->assertFalse($this->noteItemOutputDataTransformer->supportsTransformation($note, Note::class));
        $this->assertTrue($this->noteItemOutputDataTransformer->supportsTransformation($note, NoteItemOutput::class));
    }

    public function testTransform(): void
    {
        $this->purge();
        $note = $this->createNote();

        $noteItemOutput = $this->noteItemOutputDataTransformer->transform($note, NoteItemOutput::class);
        $this->assertInstanceOf(NoteItemOutput::class, $noteItemOutput);
        $this->assertSame($note->getContent(), $noteItemOutput->content);
        $this->assertSame($note->getRoutine()->getUuid(), $noteItemOutput->routine);
        $this->assertSame($note->getTitle(), $noteItemOutput->title);
    }
}
