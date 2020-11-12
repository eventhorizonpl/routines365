<?php

declare(strict_types=1);

namespace App\Faker;

use App\Entity\Note;
use App\Factory\NoteFactory;
use App\Manager\NoteManager;
use Faker\Factory;
use Faker\Generator;

class NoteFaker
{
    private Generator $faker;
    private NoteFactory $noteFactory;
    private NoteManager $noteManager;

    public function __construct(
        NoteFactory $noteFactory,
        NoteManager $noteManager
    ) {
        $this->faker = Factory::create();
        $this->noteFactory = $noteFactory;
        $this->noteManager = $noteManager;
    }

    public function createNote(
        ?string $content = null,
        ?string $title = null
    ): Note {
        if (null === $content) {
            $content = (string) $this->faker->text;
        }

        if (null === $title) {
            $title = (string) $this->faker->word;
        }

        $note = $this->noteFactory->createNoteWithRequired(
            $content,
            $title
        );

        return $note;
    }

    public function createNotePersisted(
        ?string $content = null,
        ?string $title = null
    ): Note {
        $note = $this->createNote(
            $content,
            $title
        );
        $this->noteManager->save($note);

        return $note;
    }
}
