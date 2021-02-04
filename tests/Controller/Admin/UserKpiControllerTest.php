<?php

declare(strict_types=1);

namespace App\Tests\Controller\Admin;

use App\Entity\UserKpi;
use App\Factory\UserKpiFactory;
use App\Manager\UserKpiManager;
use App\Repository\UserKpiRepository;
use App\Repository\UserRepository;
use App\Service\EmailService;
use App\Service\UserKpiService;
use App\Tests\AbstractUiTestCase;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class UserKpiControllerTest extends AbstractUiTestCase
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
        unset(
            $this->paginator,
            $this->translator,
            $this->userKpiFactory,
            $this->userKpiManager,
            $this->userKpiRepository,
            $this->userRepository
        );

        parent::tearDown();
    }

    public function createUserKpi(): UserKpi
    {
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

        return $userKpi;
    }

    public function testIndex(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $userKpi = $this->createUserKpi();

        $crawler = $this->client->request('GET', '/admin/user-kpi/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('div', 'User KPIs');
        $this->assertTrue(
            $crawler->filter('th:contains("UUID")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Email")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Date")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Deleted at")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Updated at")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Actions")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$userKpi->getUuid().'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$userKpi->getUser()->getEmail().'")')->count() > 0
        );
    }

    public function testShow(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $userKpi = $this->createUserKpi();

        $crawler = $this->client->request(
            'GET',
            '/admin/user-kpi/'.$userKpi->getUuid()
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('a:contains("Basic")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('a:contains("Relations")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('a:contains("Additional")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$userKpi->getUuid().'")')->count() > 0
        );
    }

    public function testUndelete(): void
    {
        $this->purge();
        $admin = $this->createAndLoginAdmin();
        $userKpi = $this->createUserKpi();
        $this->userKpiManager->softDelete($userKpi, (string) $admin);

        $crawler = $this->client->request(
            'GET',
            '/admin/user-kpi/'.$userKpi->getUuid().'/undelete'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("User KPIs")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$userKpi->getUuid().'")')->count() > 0
        );
    }
}
