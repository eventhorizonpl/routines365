<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Entity\UserKpi;
use App\Enum\UserKpiTypeEnum;
use App\Factory\UserKpiFactory;
use App\Faker\UserFaker;
use App\Manager\UserKpiManager;
use App\Repository\{UserKpiRepository, UserRepository};
use App\Service\{EmailService, UserKpiService};
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @internal
 */
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
        $this->managerRegistry = null;
        $this->paginator = null;
        $this->translator = null;
        $this->userFaker = null;
        $this->userKpiFactory = null;
        $this->userKpiManager = null;
        $this->userKpiRepository = null;
        $this->userRepository = null
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

        return $userKpiService->create(UserKpiTypeEnum::WEEKLY, $user);
    }

    public function testConstruct(): void
    {
        $userKpiRepository = new UserKpiRepository($this->managerRegistry);

        $this->assertInstanceOf(UserKpiRepository::class, $userKpiRepository);
    }

    public function testFindByParametersForAdmin(): void
    {
        $this->purge();
        $userKpi = $this->createUserKpi();
        $user = $userKpi->getUser();

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
            'type' => $userKpi->getType()->value,
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
        $userKpi = $this->createUserKpi();
        $user = $userKpi->getUser();

        $userKpi2 = $this->userKpiRepository->findOneByTypeAndUser($userKpi->getType()->value, $user);
        $this->assertInstanceOf(UserKpi::class, $userKpi2);
    }
}
