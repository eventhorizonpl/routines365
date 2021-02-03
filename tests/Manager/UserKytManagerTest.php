<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Entity\UserKyt;
use App\Exception\ManagerException;
use App\Faker\UserFaker;
use App\Manager\UserKytManager;
use App\Repository\UserKytRepository;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class UserKytManagerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?UserKytManager $userKytManager;
    /**
     * @inject
     */
    private ?UserKytRepository $userKytRepository;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;
    /**
     * @inject
     */
    private ?ValidatorInterface $validator;

    protected function tearDown(): void
    {
        unset(
            $this->userKytManager,
            $this->userKytRepository,
            $this->userFaker,
            $this->validator
        );

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $userKytManager = new UserKytManager(
            $this->entityManager,
            $this->validator
        );

        $this->assertInstanceOf(UserKytManager::class, $userKytManager);
    }

    public function testBulkSave(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $userKyt = $user->getUserKyt();
        $userKytId = $userKyt->getId();
        $userKyts = [];
        $userKyts[] = $userKyt;

        $userKytManager = $this->userKytManager->bulkSave($userKyts, (string) $user, 1);
        $this->assertInstanceOf(UserKytManager::class, $userKytManager);

        $userKyt2 = $this->userKytRepository->findOneById($userKytId);
        $this->assertInstanceOf(UserKyt::class, $userKyt2);
    }

    public function testDelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $userKyt = $user->getUserKyt();
        $userKytId = $userKyt->getId();

        $userKytManager = $this->userKytManager->delete($userKyt);
        $this->assertInstanceOf(UserKytManager::class, $userKytManager);

        $userKyt2 = $this->userKytRepository->findOneById($userKytId);
        $this->assertNull($userKyt2);
    }

    public function testSave(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $userKyt = $user->getUserKyt();

        $userKytManager = $this->userKytManager->save($userKyt, (string) $user, true);
        $this->assertInstanceOf(UserKytManager::class, $userKytManager);

        $userKytManager = $this->userKytManager->save($userKyt, (string) $user, true);
        $this->assertInstanceOf(UserKytManager::class, $userKytManager);
    }

    public function testSaveException(): void
    {
        $this->expectException(ManagerException::class);
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $userKyt = $user->getUserKyt();
        $userKyt->setUuid('wrong');

        $userKytManager = $this->userKytManager->save($userKyt, (string) $user, true);
    }

    public function testSoftDelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $userKyt = $user->getUserKyt();
        $userKytId = $userKyt->getId();

        $userKytManager = $this->userKytManager->softDelete($userKyt, (string) $user);
        $this->assertInstanceOf(UserKytManager::class, $userKytManager);

        $userKyt2 = $this->userKytRepository->findOneById($userKytId);
        $this->assertInstanceOf(UserKyt::class, $userKyt2);
        $this->assertTrue(null !== $userKyt2->getDeletedAt());
    }

    public function testUndelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $userKyt = $user->getUserKyt();
        $userKytId = $userKyt->getId();

        $userKytManager = $this->userKytManager->softDelete($userKyt, (string) $user);
        $this->assertInstanceOf(UserKytManager::class, $userKytManager);

        $userKyt2 = $this->userKytRepository->findOneById($userKytId);
        $this->assertInstanceOf(UserKyt::class, $userKyt2);
        $this->assertTrue(null !== $userKyt2->getDeletedAt());

        $userKytManager = $this->userKytManager->undelete($userKyt);
        $this->assertInstanceOf(UserKytManager::class, $userKytManager);

        $userKyt3 = $this->userKytRepository->findOneById($userKytId);
        $this->assertInstanceOf(UserKyt::class, $userKyt3);
        $this->assertTrue(null === $userKyt3->getDeletedAt());
    }

    public function testValidate(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $userKyt = $user->getUserKyt();

        $errors = $this->userKytManager->validate($userKyt);
        $this->assertCount(0, $errors);
    }
}
