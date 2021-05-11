<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\UserKpi;
use App\Service\UserKpiService;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
use Lexik\Bundle\MaintenanceBundle\Drivers\DriverFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{InputInterface, InputOption};
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserKpiCommand extends BaseLockableCommand
{
    protected static $defaultName = 'app:create-user-kpi';

    public function __construct(
        DriverFactory $driverFactory,
        EntityManagerInterface $entityManager,
        private UserKpiService $userKpiService
    ) {
        parent::__construct($driverFactory, $entityManager);
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Create User KPI report')
            ->addOption(
                'type',
                null,
                InputOption::VALUE_REQUIRED,
                'User KPI type',
                UserKpi::TYPE_WEEKLY
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (false === $this->lock()) {
            $output->writeln('The command is already running in another process.');

            return Command::FAILURE;
        }

        if (true === $this->hasMaintenanceLock()) {
            $output->writeln('Maintenance lock detected. Exiting.');

            return Command::FAILURE;
        }

        $type = $input->getOption('type');
        if (!(\in_array($type, UserKpi::getTypeValidationChoices(), true))) {
            throw new InvalidArgumentException('Invalid type');
        }

        $this->userKpiService->run($type);

        $this->release();

        return Command::SUCCESS;
    }
}
