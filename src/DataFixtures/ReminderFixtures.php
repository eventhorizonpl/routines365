<?php

namespace App\DataFixtures;

use App\Faker\ReminderFaker;
use App\Manager\ReminderManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class ReminderFixtures extends Fixture implements ContainerAwareInterface, DependentFixtureInterface
{
    use ContainerAwareTrait;

    public const REMINDER_LIMIT = 10;
    public const REMINDER_REFERENCE = 'reminder_reference';

    private ReminderFaker $reminderFaker;
    private ReminderManager $reminderManager;

    public function __construct(
        ReminderFaker $reminderFaker,
        ReminderManager $reminderManager
    ) {
        $this->reminderFaker = $reminderFaker;
        $this->reminderManager = $reminderManager;
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
        $reminders = [];
        if (in_array($kernel->getEnvironment(), ['dev', 'test'])) {
            for ($userId = 10; $userId <= UserFixtures::REGULAR_USER_LIMIT; ++$userId) {
                for ($routineId = 1; $routineId <= RoutineFixtures::ROUTINE_LIMIT; ++$routineId) {
                    for ($reminderId = 1; $reminderId <= self::REMINDER_LIMIT; ++$reminderId) {
                        $reminder = $this->reminderFaker->createReminder();
                        $reminder->setRoutine($this->getReference(RoutineFixtures::ROUTINE_REFERENCE.'-'.(string) $userId.'-'.(string) $routineId));
                        $reminder->setUser($this->getReference(UserFixtures::REGULAR_USER_REFERENCE.'_'.(string) $userId));
                        $reminders[] = $reminder;
                        $this->addReference(self::REMINDER_REFERENCE.'-'.(string) $userId.'-'.(string) $routineId.'-'.(string) $reminderId, $reminder);
                    }
                }
            }
        }

        $this->reminderManager->bulkSave($reminders);
    }
}
