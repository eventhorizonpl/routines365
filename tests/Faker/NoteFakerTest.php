<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\Note;
use App\Factory\NoteFactory;
use App\Faker\NoteFaker;
use App\Tests\AbstractDoctrineTestCase;

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
        unset($this->noteFactory);
        unset($this->noteFaker);

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
        $this->assertEquals($content, $note->getContent());
        $this->assertEquals($title, $note->getTitle());
    }
}
