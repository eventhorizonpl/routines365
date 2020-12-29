<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Entity\ResetPasswordRequest;
use App\Faker\UserFaker;
use App\Repository\ResetPasswordRequestRepository;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;

final class ResetPasswordRequestRepositoryTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?ManagerRegistry $managerRegistry;
    /**
     * @inject
     */
    private ?ResetPasswordRequestRepository $resetPasswordRequestRepository;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        unset(
            $this->managerRegistry,
            $this->resetPasswordRequestRepository,
            $this->userFaker
        );

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $resetPasswordRequestRepository = new ResetPasswordRequestRepository($this->managerRegistry);

        $this->assertInstanceOf(ResetPasswordRequestRepository::class, $resetPasswordRequestRepository);
    }

    public function testFindByParametersForAdmin(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $resetPasswordRequest = $this->resetPasswordRequestRepository->createResetPasswordRequest(
            $user,
            new DateTimeImmutable('NOW'),
            'email',
            'token'
        );
        $this->assertInstanceOf(ResetPasswordRequest::class, $resetPasswordRequest);
    }
}
