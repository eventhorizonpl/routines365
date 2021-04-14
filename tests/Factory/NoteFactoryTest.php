<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\Note;
use App\Factory\NoteFactory;
use App\Tests\AbstractTestCase;
use Faker\Factory;
use Faker\Generator;

/**
 * @internal
 * @coversNothing
 */
final class NoteFactoryTest extends AbstractTestCase
{
    private ?Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
    }

    protected function tearDown(): void
    {
        $this->faker = null;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $noteFactory = new NoteFactory();

        $this->assertInstanceOf(NoteFactory::class, $noteFactory);
    }

    public function testCreateNote(): void
    {
        $noteFactory = new NoteFactory();
        $note = $noteFactory->createNote();
        $this->assertInstanceOf(Note::class, $note);
    }

    public function testCreateNoteWithRequired(): void
    {
        $content = $this->faker->sentence();
        $title = $this->faker->sentence();
        $noteFactory = new NoteFactory();
        $note = $noteFactory->createNoteWithRequired(
            $content,
            $title
        );
        $this->assertInstanceOf(Note::class, $note);
        $this->assertSame($content, $note->getContent());
        $this->assertSame($title, $note->getTitle());
    }
}
