<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Faker\NoteFaker;
use App\Manager\NoteManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class V1NoteFixtures extends Fixture implements ContainerAwareInterface, DependentFixtureInterface
{
    use ContainerAwareTrait;

    public const NOTE_LIMIT = 5;
    public const NOTE_REFERENCE = 'note_reference';

    public function __construct(
        private NoteFaker $noteFaker,
        private NoteManager $noteManager
    ) {
    }

    public function getDependencies(): array
    {
        return [
            V1RoutineFixtures::class,
            V1UserFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $kernel = $this->container->get('kernel');
        $notes = [];
        if (\in_array($kernel->getEnvironment(), ['dev', 'test'], true)) {
            for ($userId = 1; $userId <= V1UserFixtures::REGULAR_USER_LIMIT; ++$userId) {
                for ($routineId = 1; $routineId <= V1RoutineFixtures::ROUTINE_LIMIT; ++$routineId) {
                    for ($noteId = 1; $noteId <= self::NOTE_LIMIT; ++$noteId) {
                        $note = $this->noteFaker->createNote();
                        $note->setRoutine($this->getReference(sprintf(
                            '%s-%d-%d',
                            V1RoutineFixtures::ROUTINE_REFERENCE,
                            $userId,
                            $routineId
                        )));
                        $note->setUser($this->getReference(sprintf(
                            '%s-%d',
                            V1UserFixtures::REGULAR_USER_REFERENCE,
                            $userId
                        )));
                        $notes[] = $note;
                        $this->addReference(sprintf(
                            '%s-%d-%d-%d',
                            self::NOTE_REFERENCE,
                            $userId,
                            $routineId,
                            $noteId
                        ), $note);
                    }
                }
            }
        }

        $this->noteManager->bulkSave($notes);
    }
}
