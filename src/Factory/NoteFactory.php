<?php

namespace App\Factory;

use App\Entity\Note;
use Symfony\Component\Uid\Uuid;

class NoteFactory
{
    public function createNote(): Note
    {
        $note = new Note();
        $note->setUuid(Uuid::v4());

        return $note;
    }

    public function createNoteWithRequired(
        string $content,
        string $title
    ): Note {
        $note = $this->createNote();

        $note
            ->setContent($content)
            ->setTitle($title);

        return $note;
    }
}
