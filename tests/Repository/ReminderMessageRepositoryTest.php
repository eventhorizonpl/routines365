<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Faker\UserFaker;
use App\Repository\ReminderMessageRepository;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;

class ReminderMessageRepositoryTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?ManagerRegistry $managerRegistry;
    /**
     * @inject
     */
    private ?ReminderMessageRepository $reminderMessageRepository;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        unset($this->managerRegistry);
        unset($this->reminderMessageRepository);
        unset($this->userFaker);

        parent::tearDown();
    }

    public function testConstruct()
    {
        $reminderMessageRepository = new ReminderMessageRepository($this->managerRegistry);

        $this->assertInstanceOf(ReminderMessageRepository::class, $reminderMessageRepository);
    }

    public function testFindByParametersForAdmin()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $reminderMessages = $this->reminderMessageRepository->findByParametersForAdmin()->getResult();
        $this->assertCount(1, $reminderMessages);
        $this->assertIsArray($reminderMessages);

        $parameters = [
            'type' => 'wrong',
        ];
        $reminderMessages = $this->reminderMessageRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $reminderMessages);
        $this->assertIsArray($reminderMessages);

        $parameters = [
            'query' => $user->getEmail(),
        ];
        $reminderMessages = $this->reminderMessageRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $reminderMessages);
        $this->assertIsArray($reminderMessages);

        $parameters = [
            'query' => 'wrong email',
        ];
        $reminderMessages = $this->reminderMessageRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $reminderMessages);
        $this->assertIsArray($reminderMessages);

        $parameters = [
            'ends_at' => new DateTimeImmutable('NOW'),
        ];
        $reminderMessages = $this->reminderMessageRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $reminderMessages);
        $this->assertIsArray($reminderMessages);

        $parameters = [
            'starts_at' => new DateTimeImmutable('+1 minute'),
        ];
        $reminderMessages = $this->reminderMessageRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $reminderMessages);
        $this->assertIsArray($reminderMessages);
    }
}
