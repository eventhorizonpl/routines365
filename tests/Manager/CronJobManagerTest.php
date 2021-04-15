<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Factory\CronJobFactory;
use App\Manager\CronJobManager;
use App\Tests\AbstractDoctrineTestCase;
use Cron\CronBundle\Entity\CronJob;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @internal
 */
final class CronJobManagerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?CronJobFactory $cronJobFactory;
    /**
     * @inject
     */
    private ?CronJobManager $cronJobManager;
    /**
     * @inject
     */
    private ?ValidatorInterface $validator;

    protected function tearDown(): void
    {
        $this->cronJobFactory = null;
        $this->cronJobManager = null;
        $this->validator = null
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

    public function testConstruct(): void
    {
        $cronJobManager = new CronJobManager($this->entityManager, $this->validator);

        $this->assertInstanceOf(CronJobManager::class, $cronJobManager);
    }

    public function testBulkSave(): void
    {
        $this->purge();
        $name = 'test name';
        $cronJob = $this->createCronJob();
        $cronJobId = $cronJob->getId();
        $cronJobs = [];
        $cronJobs[] = $cronJob;

        $cronJobManager = $this->cronJobManager->bulkSave($cronJobs, 1);
        $this->assertInstanceOf(CronJobManager::class, $cronJobManager);

        $cronJob2 = $this->entityManager->getRepository(CronJob::class)->findOneById($cronJobId);
        $this->assertInstanceOf(CronJob::class, $cronJob2);
        $this->assertSame($name, $cronJob2->getName());
    }

    public function testDelete(): void
    {
        $this->purge();
        $cronJob = $this->createCronJob();
        $cronJobId = $cronJob->getId();

        $cronJobManager = $this->cronJobManager->delete($cronJob);
        $this->assertInstanceOf(CronJobManager::class, $cronJobManager);

        $cronJob2 = $this->entityManager->getRepository(CronJob::class)->findOneById($cronJobId);
        $this->assertNull($cronJob2);
    }

    public function testSave(): void
    {
        $this->purge();
        $cronJob = $this->createCronJob();

        $cronJobManager = $this->cronJobManager->save($cronJob, true);
        $this->assertInstanceOf(CronJobManager::class, $cronJobManager);
    }
}
