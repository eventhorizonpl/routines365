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
    public function __construct(
        private CronJobFactory $cronJobFactory,
        private CronJobManager $cronJobManager
    ) {
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
            [
                'command' => 'app:post-user-kyt-messages',
                'description' => 'app:post-user-kyt-messages',
                'name' => 'app:post-user-kyt-messages',
                'schedule' => '0 14 * * *',
            ],
            [
                'command' => 'app:create-retention',
                'description' => 'app:create-retention',
                'name' => 'app:create-retention',
                'schedule' => '0 1 1 * *',
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
