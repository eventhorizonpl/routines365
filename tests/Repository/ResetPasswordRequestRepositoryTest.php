<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Entity\ResetPasswordRequest;
use App\Faker\UserFaker;
use App\Repository\ResetPasswordRequestRepository;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @internal
 * @coversNothing
 */
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
        $this->managerRegistry = null;
        $this->resetPasswordRequestRepository = null;
        $this->userFaker = null
        ;

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
