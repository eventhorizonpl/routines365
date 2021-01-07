<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\CronJobFactory;
use App\Manager\CronJobManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class V4CronJobFixtures extends Fixture implements FixtureGroupInterface
{
    private CronJobFactory $cronJobFactory;
    private CronJobManager $cronJobManager;

    public function __construct(
        CronJobFactory $cronJobFactory,
        CronJobManager $cronJobManager
    ) {
        $this->cronJobFactory = $cronJobFactory;
        $this->cronJobManager = $cronJobManager;
    }

    public static function getGroups(): array
    {
        return ['v4deployment'];
    }

    public function load(ObjectManager $manager): void
    {
        $dataset = [
            [
                'command' => 'app:create-user-kpi --type=daily',
                'description' => 'app:create-user-kpi --type=daily',
                'name' => 'app:create-user-kpi --type=daily',
                'schedule' => '0 5 * * *',
            ],
        ];

        $cronJobs = [];
        foreach ($dataset as $data) {
            $cronJobs[] = $this->cronJobFactory->createCronJobWithRequired(
                $data['command'],
                $data['description'],
                true,
                $data['name'],
                $data['schedule']
            );
        }
        $this->cronJobManager->bulkSave($cronJobs);
    }
}
