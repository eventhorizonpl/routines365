<?php

namespace App\DataFixtures;

use App\Faker\NoteFaker;
use App\Manager\NoteManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class NoteFixtures extends Fixture implements ContainerAwareInterface, DependentFixtureInterface
{
    use ContainerAwareTrait;

    public const NOTE_LIMIT = 10;
    public const NOTE_REFERENCE = 'note_reference';

    private NoteFaker $noteFaker;
    private NoteManager $noteManager;

    public function __construct(
        NoteFaker $noteFaker,
        NoteManager $noteManager
    ) {
        $this->noteFaker = $noteFaker;
        $this->noteManager = $noteManager;
    }

    public function getDependencies(): array
    {
        return [
            RoutineFixtures::class,
            UserFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $kernel = $this->container->get('kernel');
        $notes = [];
        if (in_array($kernel->getEnvironment(), ['dev', 'test'])) {
            for ($userId = 10; $userId <= UserFixtures::REGULAR_USER_LIMIT; ++$userId) {
                for ($routineId = 1; $routineId <= RoutineFixtures::ROUTINE_LIMIT; ++$routineId) {
                    for ($noteId = 1; $noteId <= self::NOTE_LIMIT; ++$noteId) {
                        $note = $this->noteFaker->createNote();
                        $note->setRoutine($this->getReference(RoutineFixtures::ROUTINE_REFERENCE.'-'.(string) $userId.'-'.(string) $routineId));
                        $note->setUser($this->getReference(UserFixtures::REGULAR_USER_REFERENCE.'_'.(string) $userId));
                        $notes[] = $note;
                        $this->addReference(self::NOTE_REFERENCE.'-'.(string) $userId.'-'.(string) $routineId.'-'.(string) $noteId, $note);
                    }
                }
            }
        }

        $this->noteManager->bulkSave($notes);
    }
}
