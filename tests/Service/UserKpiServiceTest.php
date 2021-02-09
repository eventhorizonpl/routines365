<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\UserKpi;
use App\Factory\UserKpiFactory;
use App\Faker\UserFaker;
use App\Manager\UserKpiManager;
use App\Manager\UserManager;
use App\Repository\UserKpiRepository;
use App\Repository\UserRepository;
use App\Service\EmailService;
use App\Service\UserKpiService;
use App\Tests\AbstractDoctrineTestCase;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

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
        unset(
            $this->paginator,
            $this->translator,
            $this->userFaker,
            $this->userKpiFactory,
            $this->userKpiManager,
            $this->userKpiRepository,
            $this->userKpiService,
            $this->userManager,
            $this->userRepository
        );

        parent::tearDown();
    }

    public function testConstruct(): void
    {
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

        $this->assertInstanceOf(UserKpiService::class, $userKpiService);
    }

    public function testCreate(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $type = UserKpi::TYPE_DAILY;
        $userKpi = $this->userKpiService->create(
            $type,
            $user
        );
        $this->assertInstanceOf(UserKpi::class, $userKpi);
        $this->assertEquals($type, $userKpi->getType());

        $newUserKpi = $this->userKpiService->create(
            $type,
            $user,
            $userKpi
        );
        $this->assertInstanceOf(UserKpi::class, $newUserKpi);
        $this->assertEquals($userKpi, $newUserKpi->getPreviousUserKpi());
    }

    public function testRun(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $user
            ->setIsEnabled(true)
            ->setIsVerified(true);
        $this->userManager->save($user);

        $userKpis = $this->userKpiRepository->findByParametersForAdmin()->getResult();
        $this->assertCount(0, $userKpis);
        $this->assertIsArray($userKpis);

        $type = UserKpi::TYPE_WEEKLY;
        $userKpiService = $this->userKpiService->run(
            $type
        );
        $this->assertInstanceOf(UserKpiService::class, $userKpiService);

        $userKpis = $this->userKpiRepository->findByParametersForAdmin()->getResult();
        $this->assertCount(1, $userKpis);
        $this->assertIsArray($userKpis);
    }
}