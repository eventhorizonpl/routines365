<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\CronJobFactory;
use App\Manager\CronJobManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class V1CronJobFixtures extends Fixture implements FixtureGroupInterface
{
    public function __construct(
        private CronJobFactory $cronJobFactory,
        private CronJobManager $cronJobManager
    ) {
    }

    public static function getGroups(): array
    {
        return ['v1deployment'];
    }

    public function load(ObjectManager $manager): void
    {
        $dataset = [
            [
                'command' => 'app:post-remind-messages',
                'description' => 'app:post-remind-messages',
                'name' => 'app:post-remind-messages',
                'schedule' => '* * * * *',
            ],
            [
                'command' => 'app:create-kpi',
                'description' => 'app:create-kpi',
                'name' => 'app:create-kpi',
                'schedule' => '0 3 * * *',
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
