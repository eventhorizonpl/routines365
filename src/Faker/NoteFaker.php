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

    public function __construct(
        private NoteFactory $noteFactory
    ) {
        $this->faker = Factory::create();
    }

    public function createNote(
        ?string $content = null,
        ?string $title = null
    ): Note {
        if (null === $content) {
            $content = (string) $this->faker->text();
        }

        if (null === $title) {
            $title = (string) $this->faker->text(255);
        }

        return $this->noteFactory->createNoteWithRequired(
            $content,
            $title
        );
    }
}
