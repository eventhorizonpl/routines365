<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\Note;
use App\Factory\NoteFactory;
use App\Faker\NoteFaker;
use App\Tests\AbstractDoctrineTestCase;

/**
 * @internal
 */
final class NoteFakerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?NoteFactory $noteFactory;
    /**
     * @inject
     */
    private ?NoteFaker $noteFaker;

    protected function tearDown(): void
    {
        $this->noteFactory = null;
        $this->noteFaker = null
        ;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $noteFaker = new NoteFaker($this->noteFactory);

        $this->assertInstanceOf(NoteFaker::class, $noteFaker);
    }

    public function testCreateNote(): void
    {
        $this->purge();
        $note = $this->noteFaker->createNote();
        $this->assertInstanceOf(Note::class, $note);
        $content = 'test content';
        $title = 'test title';
        $note = $this->noteFaker->createNote(
            $content,
            $title
        );
        $this->assertSame($content, $note->getContent());
        $this->assertSame($title, $note->getTitle());
    }
}
