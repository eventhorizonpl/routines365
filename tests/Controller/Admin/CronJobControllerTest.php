<?php

declare(strict_types=1);

namespace App\Tests\Controller\Admin;

use App\Factory\CronJobFactory;
use App\Manager\CronJobManager;
use App\Tests\AbstractUiTestCase;
use Cron\CronBundle\Entity\CronJob;

/**
 * @internal
 */
final class CronJobControllerTest extends AbstractUiTestCase
{
    /**
     * @inject
     */
    private ?CronJobFactory $cronJobFactory;
    /**
     * @inject
     */
    private ?CronJobManager $cronJobManager;

    protected function tearDown(): void
    {
        $this->cronJobFactory = null;
        $this->cronJobManager = null
        ;

        parent::tearDown();
    }

    public function createCronJob(): CronJob
    {
        $cronJob = $this->cronJobFactory->createCronJobWithRequired(
            'test command',
            'test description',
            false,
            'test name',
            '0 * * * *'
        );
        $this->cronJobManager->save($cronJob);

        return $cronJob;
    }

    public function testIndex(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $cronJob = $this->createCronJob();

        $crawler = $this->client->request('GET', '/admin/cron-job/');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("Cron jobs")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("ID")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Command")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Schedule")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Enabled")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Actions")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$cronJob->getId().'")')->count() > 0
        );
    }

    public function testNew(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();

        $crawler = $this->client->request(
            'GET',
            '/admin/cron-job/new'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Create a cron job")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Name")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Command")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Schedule")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Description")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Enabled")')->count() > 0
        );

        $crawler = $this->client->submitForm('Save');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('span:contains("This value should not be blank.")')->count() > 0
        );

        $name = 'test name';
        $command = 'test command';
        $schedule = 'test schedule';
        $description = 'test description';
        $crawler = $this->client->submitForm('Save', [
            'cron_job[name]' => $name,
            'cron_job[command]' => $command,
            'cron_job[schedule]' => $schedule,
            'cron_job[description]' => $description,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('td:contains("'.$name.'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$command.'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$schedule.'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$description.'")')->count() > 0
        );
    }

    public function testShow(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $cronJob = $this->createCronJob();

        $crawler = $this->client->request(
            'GET',
            '/admin/cron-job/'.$cronJob->getId()
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('a:contains("Basic")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('a:contains("Additional")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$cronJob->getId().'")')->count() > 0
        );
    }

    public function testEdit(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $cronJob = $this->createCronJob();

        $crawler = $this->client->request(
            'GET',
            '/admin/cron-job/'.$cronJob->getId().'/edit'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Edit a cron job")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Name")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Command")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Schedule")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Description")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Enabled")')->count() > 0
        );

        $name = 'test name';
        $command = 'test command';
        $schedule = 'test schedule';
        $description = 'test description';
        $crawler = $this->client->submitForm('Update', [
            'cron_job[name]' => $name,
            'cron_job[command]' => $command,
            'cron_job[schedule]' => $schedule,
            'cron_job[description]' => $description,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('td:contains("'.$name.'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$command.'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$schedule.'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$description.'")')->count() > 0
        );
    }

    public function testDelete(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $cronJob = $this->createCronJob();

        $crawler = $this->client->request(
            'GET',
            '/admin/cron-job/'.$cronJob->getId().'/edit'
        );

        $this->assertResponseIsSuccessful();

        $crawler = $this->client->submitForm('Delete');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Cron jobs")')->count() > 0
        );
    }
}
