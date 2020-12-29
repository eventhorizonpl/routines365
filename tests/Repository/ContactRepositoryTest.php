<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Faker\UserFaker;
use App\Repository\ContactRepository;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;

final class ContactRepositoryTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?ContactRepository $contactRepository;
    /**
     * @inject
     */
    private ?ManagerRegistry $managerRegistry;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        unset($this->contactRepository);
        unset($this->managerRegistry);
        unset($this->userFaker);

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $contactRepository = new ContactRepository($this->managerRegistry);

        $this->assertInstanceOf(ContactRepository::class, $contactRepository);
    }

    public function testFindByParametersForAdmin(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $contacts = $this->contactRepository->findByParametersForAdmin()->getResult();
        $this->assertCount(1, $contacts);
        $this->assertIsArray($contacts);

        $parameters = [
            'type' => 'wrong',
        ];
        $contacts = $this->contactRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $contacts);
        $this->assertIsArray($contacts);

        $parameters = [
            'status' => 'wrong',
        ];
        $contacts = $this->contactRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $contacts);
        $this->assertIsArray($contacts);

        $parameters = [
            'query' => $user->getEmail(),
        ];
        $contacts = $this->contactRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $contacts);
        $this->assertIsArray($contacts);

        $parameters = [
            'query' => 'wrong email',
        ];
        $contacts = $this->contactRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $contacts);
        $this->assertIsArray($contacts);

        $parameters = [
            'ends_at' => new DateTimeImmutable('NOW'),
        ];
        $contacts = $this->contactRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $contacts);
        $this->assertIsArray($contacts);

        $parameters = [
            'starts_at' => new DateTimeImmutable('+1 minute'),
        ];
        $contacts = $this->contactRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $contacts);
        $this->assertIsArray($contacts);
    }
}
