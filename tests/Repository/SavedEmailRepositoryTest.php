<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Faker\UserFaker;
use App\Repository\SavedEmailRepository;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;

final class SavedEmailRepositoryTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?ManagerRegistry $managerRegistry;
    /**
     * @inject
     */
    private ?SavedEmailRepository $savedEmailRepository;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        unset(
            $this->managerRegistry,
            $this->savedEmailRepository,
            $this->userFaker
        );

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $savedEmailRepository = new SavedEmailRepository($this->managerRegistry);

        $this->assertInstanceOf(SavedEmailRepository::class, $savedEmailRepository);
    }

    public function testFindByParametersForAdmin(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $savedEmails = $this->savedEmailRepository->findByParametersForAdmin()->getResult();
        $this->assertCount(1, $savedEmails);
        $this->assertIsArray($savedEmails);

        $parameters = [
            'type' => 'wrong',
        ];
        $savedEmails = $this->savedEmailRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $savedEmails);
        $this->assertIsArray($savedEmails);

        $parameters = [
            'query' => $user->getEmail(),
        ];
        $savedEmails = $this->savedEmailRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $savedEmails);
        $this->assertIsArray($savedEmails);

        $parameters = [
            'query' => 'wrong email',
        ];
        $savedEmails = $this->savedEmailRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $savedEmails);
        $this->assertIsArray($savedEmails);

        $parameters = [
            'ends_at' => new DateTimeImmutable('NOW'),
        ];
        $savedEmails = $this->savedEmailRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $savedEmails);
        $this->assertIsArray($savedEmails);

        $parameters = [
            'starts_at' => new DateTimeImmutable('+1 minute'),
        ];
        $savedEmails = $this->savedEmailRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $savedEmails);
        $this->assertIsArray($savedEmails);
    }
}
