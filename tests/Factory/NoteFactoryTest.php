<?php

declare(strict_types=1);

namespace App\Tests\Util;

use App\Entity\Note;
use App\Factory\NoteFactory;
use App\Tests\AbstractTestCase;
use Faker\Factory;
use Faker\Generator;

class NoteFactoryTest extends AbstractTestCase
{
    private ?Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
    }

    protected function tearDown(): void
    {
        unset($this->faker);

        parent::tearDown();
    }

    public function testConstruct()
    {
        $noteFactory = new NoteFactory();

        $this->assertInstanceOf(NoteFactory::class, $noteFactory);
    }

    public function testCreateNote()
    {
        $noteFactory = new NoteFactory();
        $note = $noteFactory->createNote();
        $this->assertInstanceOf(Note::class, $note);
    }

    public function testCreateNoteWithRequired()
    {
        $content = $this->faker->sentence;
        $title = $this->faker->sentence;
        $noteFactory = new NoteFactory();
        $note = $noteFactory->createNoteWithRequired(
            $content,
            $title
        );
        $this->assertInstanceOf(Note::class, $note);
        $this->assertEquals($content, $note->getContent());
        $this->assertEquals($title, $note->getTitle());
    }
}
