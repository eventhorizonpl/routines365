<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Entity\UserKpi;
use App\Factory\UserKpiFactory;
use App\Faker\UserFaker;
use App\Manager\UserKpiManager;
use App\Repository\UserKpiRepository;
use App\Repository\UserRepository;
use App\Service\EmailService;
use App\Service\UserKpiService;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class UserKpiRepositoryTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?ManagerRegistry $managerRegistry;
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

    protected function tearDown(): void
    {
        unset($this->managerRegistry);
        unset($this->paginator);
        unset($this->translator);
        unset($this->userFaker);
        unset($this->userKpiFactory);
        unset($this->userKpiManager);
        unset($this->userKpiRepository);
        unset($this->userRepository);

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $userKpiRepository = new UserKpiRepository($this->managerRegistry);

        $this->assertInstanceOf(UserKpiRepository::class, $userKpiRepository);
    }

    public function testFindByParametersForAdmin(): void
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

        $userKpis = $this->userKpiRepository->findByParametersForAdmin()->getResult();
        $this->assertCount(1, $userKpis);
        $this->assertIsArray($userKpis);

        $parameters = [
            'query' => $user->getEmail(),
        ];
        $userKpis = $this->userKpiRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $userKpis);
        $this->assertIsArray($userKpis);

        $parameters = [
            'type' => $userKpi->getType(),
        ];
        $userKpis = $this->userKpiRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $userKpis);
        $this->assertIsArray($userKpis);

        $parameters = [
            'ends_at' => new DateTimeImmutable('NOW'),
        ];
        $userKpis = $this->userKpiRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $userKpis);
        $this->assertIsArray($userKpis);

        $parameters = [
            'starts_at' => new DateTimeImmutable('+1 minute'),
        ];
        $userKpis = $this->userKpiRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $userKpis);
        $this->assertIsArray($userKpis);
    }

    public function testFindOneByTypeAndUser(): void
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

        $userKpi2 = $this->userKpiRepository->findOneByTypeAndUser($userKpi->getType(), $user);
        $this->assertInstanceOf(UserKpi::class, $userKpi2);
    }
}
