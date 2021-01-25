<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Faker\ReminderFaker;
use App\Manager\ReminderManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class V1ReminderFixtures extends Fixture implements ContainerAwareInterface, DependentFixtureInterface
{
    use ContainerAwareTrait;

    public const REMINDER_LIMIT = 5;
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
            V1RoutineFixtures::class,
            V1UserFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $kernel = $this->container->get('kernel');
        $reminders = [];
        if (in_array($kernel->getEnvironment(), ['dev', 'test'])) {
            for ($userId = 1; $userId <= V1UserFixtures::REGULAR_USER_LIMIT; ++$userId) {
                for ($routineId = 1; $routineId <= V1RoutineFixtures::ROUTINE_LIMIT; ++$routineId) {
                    for ($reminderId = 1; $reminderId <= self::REMINDER_LIMIT; ++$reminderId) {
                        $reminder = $this->reminderFaker->createReminder();
                        $reminder->setRoutine($this->getReference(sprintf(
                            '%s-%d-%d',
                            V1RoutineFixtures::ROUTINE_REFERENCE,
                            $userId,
                            $routineId
                        )));
                        $reminder->setUser($this->getReference(sprintf(
                            '%s-%d',
                            V1UserFixtures::REGULAR_USER_REFERENCE,
                            $userId
                        )));
                        $reminders[] = $reminder;
                        $this->addReference(sprintf(
                            '%s-%d-%d-%d',
                            self::REMINDER_REFERENCE,
                            $userId,
                            $routineId,
                            $reminderId
                        ), $reminder);
                    }
                }
            }
        }

        $this->reminderManager->bulkSave($reminders);
    }
}
