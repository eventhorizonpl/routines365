<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\CronJobFactory;
use App\Manager\CronJobManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class V3CronJobFixtures extends Fixture implements FixtureGroupInterface
{
    public function __construct(
        private CronJobFactory $cronJobFactory,
        private CronJobManager $cronJobManager
    ) {
    }

    public static function getGroups(): array
    {
        return ['v3deployment'];
    }

    public function load(ObjectManager $manager): void
    {
        $dataset = [
            [
                'command' => 'app:cleanup-sessions',
                'description' => 'app:cleanup-sessions',
                'name' => 'app:cleanup-sessions',
                'schedule' => '0 3 * * *',
            ],
            [
                'command' => 'app:create-user-kpi --type=weekly',
                'description' => 'app:create-user-kpi --type=weekly',
                'name' => 'app:create-user-kpi --type=weekly',
                'schedule' => '0 4 * * 1',
            ],
            [
                'command' => 'app:create-user-kpi --type=monthly',
                'description' => 'app:create-user-kpi --type=monthly',
                'name' => 'app:create-user-kpi --type=monthly',
                'schedule' => '20 4 1 * *',
            ],
            [
                'command' => 'app:create-user-kpi --type=annually',
                'description' => 'app:create-user-kpi --type=annually',
                'name' => 'app:create-user-kpi --type=annually',
                'schedule' => '40 4 1 1 *',
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
