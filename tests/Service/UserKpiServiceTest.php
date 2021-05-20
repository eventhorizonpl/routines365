<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\UserKpi;
use App\Enum\UserKpiTypeEnum;
use App\Factory\UserKpiFactory;
use App\Faker\UserFaker;
use App\Manager\{UserKpiManager, UserManager};
use App\Repository\{UserKpiRepository, UserRepository};
use App\Service\{EmailService, UserKpiService};
use App\Tests\AbstractDoctrineTestCase;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @internal
 */
final class UserKpiServiceTest extends AbstractDoctrineTestCase
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
    private ?UserKpiService $userKpiService;
    /**
     * @inject
     */
    private ?UserManager $userManager;
    /**
     * @inject
     */
    private ?UserRepository $userRepository;

    protected function tearDown(): void
    {
        $this->paginator = null;
        $this->translator = null;
        $this->userFaker = null;
        $this->userKpiFactory = null;
        $this->userKpiManager = null;
        $this->userKpiRepository = null;
        $this->userKpiService = null;
        $this->userManager = null;
        $this->userRepository = null
        ;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
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

        $this->assertInstanceOf(UserKpiService::class, $userKpiService);
    }

    public function testCreate(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $type = UserKpiTypeEnum::DAILY;
        $userKpi = $this->userKpiService->create(
            $type,
            $user
        );
        $this->assertInstanceOf(UserKpi::class, $userKpi);
        $this->assertSame($type, $userKpi->getType());

        $newUserKpi = $this->userKpiService->create(
            $type,
            $user,
            $userKpi
        );
        $this->assertInstanceOf(UserKpi::class, $newUserKpi);
        $this->assertSame($userKpi, $newUserKpi->getPreviousUserKpi());
    }

    public function testRun(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $user
            ->setIsEnabled(true)
            ->setIsVerified(true)
        ;
        $this->userManager->save($user);

        $userKpis = $this->userKpiRepository->findByParametersForAdmin()->getResult();
        $this->assertCount(0, $userKpis);
        $this->assertIsArray($userKpis);

        $type = UserKpiTypeEnum::WEEKLY;
        $userKpiService = $this->userKpiService->run(
            $type
        );
        $this->assertInstanceOf(UserKpiService::class, $userKpiService);

        $userKpis = $this->userKpiRepository->findByParametersForAdmin()->getResult();
        $this->assertCount(1, $userKpis);
        $this->assertIsArray($userKpis);
    }
}
