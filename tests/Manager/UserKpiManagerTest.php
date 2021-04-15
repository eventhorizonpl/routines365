<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Entity\UserKpi;
use App\Exception\ManagerException;
use App\Factory\UserKpiFactory;
use App\Faker\UserFaker;
use App\Manager\UserKpiManager;
use App\Repository\{UserKpiRepository, UserRepository};
use App\Service\{EmailService, UserKpiService};
use App\Tests\AbstractDoctrineTestCase;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @internal
 * @coversNothing
 */
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
        $this->paginator = null;
        $this->translator = null;
        $this->userFaker = null;
        $this->userKpiFactory = null;
        $this->userKpiManager = null;
        $this->userKpiRepository = null;
        $this->userKpiService = null;
        $this->userRepository = null;
        $this->validator = null
        ;

        parent::tearDown();
    }

    public function createUserKpi(): UserKpi
    {
        $user = $this->userFaker->createRichUserPersisted();
        $emailService = $this->getMockBuilder(EmailService::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $userKpiService = new UserKpiService(
            $emailService,
            $this->paginator,
            $this->translator,
            $this->userKpiFactory,
            $this->userKpiManager,
            $this->userKpiRepository,
            $this->userRepository
        );

        return $userKpiService->create(UserKpi::TYPE_WEEKLY, $user);
    }

    public function testConstruct(): void
    {
        $userKpiManager = new UserKpiManager($this->entityManager, $this->validator);

        $this->assertInstanceOf(UserKpiManager::class, $userKpiManager);
    }

    public function testBulkSave(): void
    {
        $this->purge();
        $userKpi = $this->createUserKpi();
        $accountOperationCounter = 987;
        $userKpi->setAccountOperationCounter($accountOperationCounter);
        $userKpiId = $userKpi->getId();
        $userKpis = [];
        $userKpis[] = $userKpi;

        $userKpiManager = $this->userKpiManager->bulkSave($userKpis, 1);
        $this->assertInstanceOf(UserKpiManager::class, $userKpiManager);

        $userKpi2 = $this->userKpiRepository->findOneById($userKpiId);
        $this->assertInstanceOf(UserKpi::class, $userKpi2);
        $this->assertSame($accountOperationCounter, $userKpi2->getAccountOperationCounter());
    }

    public function testDelete(): void
    {
        $this->purge();
        $userKpi = $this->createUserKpi();
        $userKpiId = $userKpi->getId();

        $userKpiManager = $this->userKpiManager->delete($userKpi);
        $this->assertInstanceOf(UserKpiManager::class, $userKpiManager);

        $userKpi2 = $this->userKpiRepository->findOneById($userKpiId);
        $this->assertNull($userKpi2);
    }

    public function testSave(): void
    {
        $this->purge();
        $userKpi = $this->createUserKpi();

        $userKpiManager = $this->userKpiManager->save($userKpi, true);
        $this->assertInstanceOf(UserKpiManager::class, $userKpiManager);

        $userKpiManager = $this->userKpiManager->save($userKpi);
        $this->assertInstanceOf(UserKpiManager::class, $userKpiManager);
    }

    public function testSaveException(): void
    {
        $this->expectException(ManagerException::class);
        $this->purge();
        $userKpi = $this->createUserKpi();
        $userKpi->setAccountOperationCounter(-1);

        $userKpiManager = $this->userKpiManager->save($userKpi, true);
    }

    public function testSoftDelete(): void
    {
        $this->purge();
        $userKpi = $this->createUserKpi();
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
        $userKpi = $this->createUserKpi();
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
        $userKpi = $this->createUserKpi();

        $errors = $this->userKpiManager->validate($userKpi);
        $this->assertCount(0, $errors);

        $userKpi->setAccountOperationCounter(-1);
        $errors = $this->userKpiManager->validate($userKpi);
        $this->assertCount(1, $errors);
    }
}
