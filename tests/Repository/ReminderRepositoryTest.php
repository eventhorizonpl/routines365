<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Entity\Reminder;
use App\Faker\UserFaker;
use App\Repository\ReminderRepository;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;

class ReminderRepositoryTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?ManagerRegistry $managerRegistry;
    /**
     * @inject
     */
    private ?ReminderRepository $reminderRepository;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        unset($this->managerRegistry);
        unset($this->reminderRepository);
        unset($this->userFaker);

        parent::tearDown();
    }

    public function testConstruct()
    {
        $reminderRepository = new ReminderRepository($this->managerRegistry);

        $this->assertInstanceOf(ReminderRepository::class, $reminderRepository);
    }

    public function testFindByParametersForAdmin()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $reminders = $this->reminderRepository->findByParametersForAdmin()->getResult();
        $this->assertCount(1, $reminders);
        $this->assertIsArray($reminders);

        $parameters = [
            'type' => 'wrong',
        ];
        $reminders = $this->reminderRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $reminders);
        $this->assertIsArray($reminders);

        $parameters = [
            'query' => $user->getEmail(),
        ];
        $reminders = $this->reminderRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $reminders);
        $this->assertIsArray($reminders);

        $parameters = [
            'query' => 'wrong email',
        ];
        $reminders = $this->reminderRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $reminders);
        $this->assertIsArray($reminders);

        $parameters = [
            'ends_at' => new DateTimeImmutable('NOW'),
        ];
        $reminders = $this->reminderRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $reminders);
        $this->assertIsArray($reminders);

        $parameters = [
            'starts_at' => new DateTimeImmutable('+1 minute'),
        ];
        $reminders = $this->reminderRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $reminders);
        $this->assertIsArray($reminders);
    }

    public function testFindOneByNextDate()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $reminder = $user->getReminders()->first();

        $reminderResult = $this->reminderRepository->findOneByNextDate($reminder->getNextDate());
        if ((true === $reminder->getIsEnabled()) && (true === $reminder->getRoutine()->getIsEnabled())) {
            $this->assertInstanceOf(Reminder::class, $reminderResult);
            $this->assertEquals($reminder, $reminderResult);
        } else {
            $this->assertEquals(null, $reminderResult);
        }
    }

    public function testFindOneByUser()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $reminder = $user->getReminders()->first();

        $reminderResult = $this->reminderRepository->findOneByUser($user);
        if ((true === $reminder->getIsEnabled()) && (true === $reminder->getRoutine()->getIsEnabled())) {
            $this->assertInstanceOf(Reminder::class, $reminderResult);
            $this->assertEquals($reminder, $reminderResult);
        } else {
            $this->assertEquals(null, $reminderResult);
        }
    }

    public function testFindByLockedAt()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $lockedAt = new DateTimeImmutable('NOW');
        $reminders = $this->reminderRepository->findByLockedAt($lockedAt);
        $this->assertCount(0, $reminders);
        $this->assertIsArray($reminders);
    }
}
