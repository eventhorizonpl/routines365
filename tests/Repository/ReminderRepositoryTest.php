<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Entity\Reminder;
use App\Faker\UserFaker;
use App\Repository\ReminderRepository;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @internal
 */
final class ReminderRepositoryTest extends AbstractDoctrineTestCase
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
        $this->managerRegistry = null;
        $this->reminderRepository = null;
        $this->userFaker = null
        ;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $reminderRepository = new ReminderRepository($this->managerRegistry);

        $this->assertInstanceOf(ReminderRepository::class, $reminderRepository);
    }

    public function testFindByParametersForAdmin(): void
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

    public function testFindOneByNextDate(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $reminder = $user->getReminders()->first();

        $reminderResult = $this->reminderRepository->findOneByNextDate($reminder->getNextDate());
        if ((true === $reminder->getIsEnabled()) && (true === $reminder->getRoutine()->getIsEnabled())) {
            $this->assertInstanceOf(Reminder::class, $reminderResult);
            $this->assertSame($reminder, $reminderResult);
        } else {
            $this->assertNull($reminderResult);
        }
    }

    public function testFindOneByUser(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $reminder = $user->getReminders()->first();

        $reminderResult = $this->reminderRepository->findOneByUser($user);
        if ((true === $reminder->getIsEnabled()) && (true === $reminder->getRoutine()->getIsEnabled())) {
            $this->assertInstanceOf(Reminder::class, $reminderResult);
            $this->assertSame($reminder, $reminderResult);
        } else {
            $this->assertNull($reminderResult);
        }
    }

    public function testFindByLockedAt(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $lockedAt = new DateTimeImmutable('NOW');
        $reminders = $this->reminderRepository->findByLockedAt($lockedAt);
        $this->assertCount(0, $reminders);
        $this->assertIsArray($reminders);
    }
}
