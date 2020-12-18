<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Faker\UserFaker;
use App\Repository\SentReminderRepository;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;

final class SentReminderRepositoryTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?ManagerRegistry $managerRegistry;
    /**
     * @inject
     */
    private ?SentReminderRepository $sentReminderRepository;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        unset($this->managerRegistry);
        unset($this->sentReminderRepository);
        unset($this->userFaker);

        parent::tearDown();
    }

    public function testConstruct()
    {
        $sentReminderRepository = new SentReminderRepository($this->managerRegistry);

        $this->assertInstanceOf(SentReminderRepository::class, $sentReminderRepository);
    }

    public function testFindByParametersForAdmin()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $sentReminders = $this->sentReminderRepository->findByParametersForAdmin()->getResult();
        $this->assertCount(1, $sentReminders);
        $this->assertIsArray($sentReminders);

        $parameters = [
            'ends_at' => new DateTimeImmutable('NOW'),
        ];
        $sentReminders = $this->sentReminderRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $sentReminders);
        $this->assertIsArray($sentReminders);

        $parameters = [
            'starts_at' => new DateTimeImmutable('+1 minute'),
        ];
        $sentReminders = $this->sentReminderRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $sentReminders);
        $this->assertIsArray($sentReminders);
    }
}
