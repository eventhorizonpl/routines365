<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Entity\Retention;
use App\Exception\ManagerException;
use App\Factory\RetentionFactory;
use App\Faker\UserFaker;
use App\Manager\RetentionManager;
use App\Repository\RetentionRepository;
use App\Service\RetentionService;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class RetentionManagerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?RetentionFactory $retentionFactory;
    /**
     * @inject
     */
    private ?RetentionManager $retentionManager;
    /**
     * @inject
     */
    private ?RetentionRepository $retentionRepository;
    /**
     * @inject
     */
    private ?RetentionService $retentionService;
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
            $this->retentionFactory,
            $this->retentionManager,
            $this->retentionRepository,
            $this->retentionService,
            $this->userFaker,
            $this->validator
        );

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $retentionManager = new RetentionManager($this->entityManager, $this->validator);

        $this->assertInstanceOf(RetentionManager::class, $retentionManager);
    }

    public function testBulkSave(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $data = ['test'];
        $this->retentionService->run();
        $retentions = $this->retentionRepository->findAll();
        $retention = $retentions[0];
        $retention->setData($data);
        $retentionId = $retention->getId();
        $retentions = [];
        $retentions[] = $retention;

        $retentionManager = $this->retentionManager->bulkSave($retentions, 1);
        $this->assertInstanceOf(RetentionManager::class, $retentionManager);

        $retention2 = $this->retentionRepository->findOneById($retentionId);
        $this->assertInstanceOf(Retention::class, $retention2);
        $this->assertEquals($data, $retention2->getData());
    }

    public function testDelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $this->retentionService->run();
        $retentions = $this->retentionRepository->findAll();
        $retention = $retentions[0];
        $retentionId = $retention->getId();

        $retentionManager = $this->retentionManager->delete($retention);
        $this->assertInstanceOf(RetentionManager::class, $retentionManager);

        $retention2 = $this->retentionRepository->findOneById($retentionId);
        $this->assertNull($retention2);
    }

    public function testSave(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $this->retentionService->run();
        $retentions = $this->retentionRepository->findAll();
        $retention = $retentions[0];

        $retentionManager = $this->retentionManager->save($retention);
        $this->assertInstanceOf(RetentionManager::class, $retentionManager);
    }

    public function testSaveException(): void
    {
        $this->expectException(ManagerException::class);
        $this->purge();
        $retention = $this->retentionFactory->createRetention();

        $retentionManager = $this->retentionManager->save($retention);
    }

    public function testSoftDelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $this->retentionService->run();
        $retentions = $this->retentionRepository->findAll();
        $retention = $retentions[0];
        $retentionId = $retention->getId();

        $retentionManager = $this->retentionManager->softDelete($retention);
        $this->assertInstanceOf(RetentionManager::class, $retentionManager);

        $retention2 = $this->retentionRepository->findOneById($retentionId);
        $this->assertInstanceOf(Retention::class, $retention2);
        $this->assertTrue(null !== $retention2->getDeletedAt());
    }

    public function testUndelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $this->retentionService->run();
        $retentions = $this->retentionRepository->findAll();
        $retention = $retentions[0];
        $retentionId = $retention->getId();

        $retentionManager = $this->retentionManager->softDelete($retention);
        $this->assertInstanceOf(RetentionManager::class, $retentionManager);

        $retention2 = $this->retentionRepository->findOneById($retentionId);
        $this->assertInstanceOf(Retention::class, $retention2);
        $this->assertTrue(null !== $retention2->getDeletedAt());

        $retentionManager = $this->retentionManager->undelete($retention);
        $this->assertInstanceOf(RetentionManager::class, $retentionManager);

        $retention3 = $this->retentionRepository->findOneById($retentionId);
        $this->assertInstanceOf(Retention::class, $retention3);
        $this->assertTrue(null === $retention3->getDeletedAt());
    }

    public function testValidate(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $this->retentionService->run();
        $retentions = $this->retentionRepository->findAll();
        $retention = $retentions[0];

        $errors = $this->retentionManager->validate($retention);
        $this->assertCount(0, $errors);

        $retention = $this->retentionFactory->createRetention();
        $errors = $this->retentionManager->validate($retention);
        $this->assertCount(4, $errors);
    }
}
