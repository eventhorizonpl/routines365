<?php

declare(strict_types=1);

namespace App\Faker;

use App\Entity\Note;
use App\Factory\NoteFactory;
use Faker\Factory;
use Faker\Generator;

class NoteFaker
{
    private Generator $faker;
    private NoteFactory $noteFactory;

    public function __construct(
        NoteFactory $noteFactory
    ) {
        $this->faker = Factory::create();
        $this->noteFactory = $noteFactory;
    }

    public function createNote(
        ?string $content = null,
        ?string $title = null
    ): Note {
        if (null === $content) {
            $content = (string) $this->faker->text;
        }

        if (null === $title) {
            $title = (string) $this->faker->text(255);
        }

        $note = $this->noteFactory->createNoteWithRequired(
            $content,
            $title
        );

        return $note;
    }
}
