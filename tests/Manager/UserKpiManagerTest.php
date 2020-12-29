<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Entity\UserKpi;
use App\Exception\ManagerException;
use App\Factory\UserKpiFactory;
use App\Faker\UserFaker;
use App\Manager\UserKpiManager;
use App\Repository\UserKpiRepository;
use App\Repository\UserRepository;
use App\Service\EmailService;
use App\Service\UserKpiService;
use App\Tests\AbstractDoctrineTestCase;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class UserKpiManagerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?PaginatorInterface $paginator;
    /**
     * @inject
     */
    private ?TranslatorInterface $translator;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;
    /**
     * @inject
     */
    private ?UserKpiFactory $userKpiFactory;
    /**
     * @inject
     */
    private ?UserKpiManager $userKpiManager;
    /**
     * @inject
     */
    private ?UserKpiRepository $userKpiRepository;
    /**
     * @inject
     */
    private ?UserRepository $userRepository;
    /**
     * @inject
     */
    private ?ValidatorInterface $validator;

    protected function tearDown(): void
    {
        unset(
            $this->paginator,
            $this->translator,
            $this->userFaker,
            $this->userKpiFactory,
            $this->userKpiManager,
            $this->userKpiRepository,
            $this->userKpiService,
            $this->userRepository,
            $this->validator
        );

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $userKpiManager = new UserKpiManager($this->entityManager, $this->validator);

        $this->assertInstanceOf(UserKpiManager::class, $userKpiManager);
    }

    public function testBulkSave(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $accountOperationCounter = 987;
        $emailService = $this->getMockBuilder(EmailService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $userKpiService = new UserKpiService(
            $emailService,
            $this->paginator,
            $this->translator,
            $this->userKpiFactory,
            $this->userKpiManager,
            $this->userKpiRepository,
            $this->userRepository
        );
        $userKpi = $userKpiService->create(UserKpi::TYPE_WEEKLY, $user);
        $userKpi->setAccountOperationCounter($accountOperationCounter);
        $userKpiId = $userKpi->getId();
        $userKpis = [];
        $userKpis[] = $userKpi;

        $userKpiManager = $this->userKpiManager->bulkSave($userKpis, 1);
        $this->assertInstanceOf(UserKpiManager::class, $userKpiManager);

        $userKpi2 = $this->userKpiRepository->findOneById($userKpiId);
        $this->assertInstanceOf(UserKpi::class, $userKpi2);
        $this->assertEquals($accountOperationCounter, $userKpi2->getAccountOperationCounter());
    }

    public function testDelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $emailService = $this->getMockBuilder(EmailService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $userKpiService = new UserKpiService(
            $emailService,
            $this->paginator,
            $this->translator,
            $this->userKpiFactory,
            $this->userKpiManager,
            $this->userKpiRepository,
            $this->userRepository
        );
        $userKpi = $userKpiService->create(UserKpi::TYPE_WEEKLY, $user);
        $userKpiId = $userKpi->getId();

        $userKpiManager = $this->userKpiManager->delete($userKpi);
        $this->assertInstanceOf(UserKpiManager::class, $userKpiManager);

        $userKpi2 = $this->userKpiRepository->findOneById($userKpiId);
        $this->assertNull($userKpi2);
    }

    public function testSave(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $emailService = $this->getMockBuilder(EmailService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $userKpiService = new UserKpiService(
            $emailService,
            $this->paginator,
            $this->translator,
            $this->userKpiFactory,
            $this->userKpiManager,
            $this->userKpiRepository,
            $this->userRepository
        );
        $userKpi = $userKpiService->create(UserKpi::TYPE_WEEKLY, $user);

        $userKpiManager = $this->userKpiManager->save($userKpi, true);
        $this->assertInstanceOf(UserKpiManager::class, $userKpiManager);

        $userKpiManager = $this->userKpiManager->save($userKpi);
        $this->assertInstanceOf(UserKpiManager::class, $userKpiManager);
    }

    public function testSaveException(): void
    {
        $this->expectException(ManagerException::class);
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $emailService = $this->getMockBuilder(EmailService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $userKpiService = new UserKpiService(
            $emailService,
            $this->paginator,
            $this->translator,
            $this->userKpiFactory,
            $this->userKpiManager,
            $this->userKpiRepository,
            $this->userRepository
        );
        $userKpi = $userKpiService->create(UserKpi::TYPE_WEEKLY, $user);
        $userKpi->setAccountOperationCounter(-1);

        $userKpiManager = $this->userKpiManager->save($userKpi, true);
    }

    public function testSoftDelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $emailService = $this->getMockBuilder(EmailService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $userKpiService = new UserKpiService(
            $emailService,
            $this->paginator,
            $this->translator,
            $this->userKpiFactory,
            $this->userKpiManager,
            $this->userKpiRepository,
            $this->userRepository
        );
        $userKpi = $userKpiService->create(UserKpi::TYPE_WEEKLY, $user);
        $userKpiId = $userKpi->getId();

        $userKpiManager = $this->userKpiManager->softDelete($userKpi);
        $this->assertInstanceOf(UserKpiManager::class, $userKpiManager);

        $userKpi2 = $this->userKpiRepository->findOneById($userKpiId);
        $this->assertInstanceOf(UserKpi::class, $userKpi2);
        $this->assertTrue(null !== $userKpi2->getDeletedAt());
    }

    public function testUndelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $emailService = $this->getMockBuilder(EmailService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $userKpiService = new UserKpiService(
            $emailService,
            $this->paginator,
            $this->translator,
            $this->userKpiFactory,
            $this->userKpiManager,
            $this->userKpiRepository,
            $this->userRepository
        );
        $userKpi = $userKpiService->create(UserKpi::TYPE_WEEKLY, $user);
        $userKpiId = $userKpi->getId();

        $userKpiManager = $this->userKpiManager->softDelete($userKpi);
        $this->assertInstanceOf(UserKpiManager::class, $userKpiManager);

        $userKpi2 = $this->userKpiRepository->findOneById($userKpiId);
        $this->assertInstanceOf(UserKpi::class, $userKpi2);
        $this->assertTrue(null !== $userKpi2->getDeletedAt());

        $userKpiManager = $this->userKpiManager->undelete($userKpi);
        $this->assertInstanceOf(UserKpiManager::class, $userKpiManager);

        $userKpi3 = $this->userKpiRepository->findOneById($userKpiId);
        $this->assertInstanceOf(UserKpi::class, $userKpi3);
        $this->assertTrue(null === $userKpi3->getDeletedAt());
    }

    public function testValidate(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $emailService = $this->getMockBuilder(EmailService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $userKpiService = new UserKpiService(
            $emailService,
            $this->paginator,
            $this->translator,
            $this->userKpiFactory,
            $this->userKpiManager,
            $this->userKpiRepository,
            $this->userRepository
        );
        $userKpi = $userKpiService->create(UserKpi::TYPE_WEEKLY, $user);

        $errors = $this->userKpiManager->validate($userKpi);
        $this->assertCount(0, $errors);

        $userKpi->setAccountOperationCounter(-1);
        $errors = $this->userKpiManager->validate($userKpi);
        $this->assertCount(1, $errors);
    }
}
