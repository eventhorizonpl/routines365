<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Manager\CronJobManager;
use App\Tests\AbstractDoctrineTestCase;
use Cron\CronBundle\Entity\CronJob;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class CronJobManagerTest extends AbstractDoctrineTestCase
{
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
        unset(
            $this->cronJobManager,
            $this->validator
        );

        parent::tearDown();
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
        $cronJob = new CronJob();
        $cronJob
            ->setCommand('test')
            ->setDescription('test')
            ->setEnabled(false)
            ->setName($name)
            ->setSchedule('0 * * * *');
        $this->entityManager->persist($cronJob);
        $this->entityManager->flush();
        $cronJobId = $cronJob->getId();
        $cronJobs = [];
        $cronJobs[] = $cronJob;

        $cronJobManager = $this->cronJobManager->bulkSave($cronJobs, 1);
        $this->assertInstanceOf(CronJobManager::class, $cronJobManager);

        $cronJob2 = $this->entityManager->getRepository(CronJob::class)->findOneById($cronJobId);
        $this->assertInstanceOf(CronJob::class, $cronJob2);
        $this->assertEquals($name, $cronJob2->getName());
    }

    public function testDelete(): void
    {
        $this->purge();
        $cronJob = new CronJob();
        $cronJob
            ->setCommand('test')
            ->setDescription('test')
            ->setEnabled(false)
            ->setName('test')
            ->setSchedule('0 * * * *');
        $this->entityManager->persist($cronJob);
        $this->entityManager->flush();
        $cronJobId = $cronJob->getId();

        $cronJobManager = $this->cronJobManager->delete($cronJob);
        $this->assertInstanceOf(CronJobManager::class, $cronJobManager);

        $cronJob2 = $this->entityManager->getRepository(CronJob::class)->findOneById($cronJobId);
        $this->assertNull($cronJob2);
    }

    public function testSave(): void
    {
        $this->purge();
        $cronJob = new CronJob();
        $cronJob
            ->setCommand('test')
            ->setDescription('test')
            ->setEnabled(false)
            ->setName('test')
            ->setSchedule('0 * * * *');
        $this->entityManager->persist($cronJob);
        $this->entityManager->flush();

        $cronJobManager = $this->cronJobManager->save($cronJob, true);
        $this->assertInstanceOf(CronJobManager::class, $cronJobManager);
    }
}
