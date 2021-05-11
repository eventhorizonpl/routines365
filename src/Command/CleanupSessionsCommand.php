<?php

declare(strict_types=1);

namespace App\Command;

use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\MaintenanceBundle\Drivers\DriverFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CleanupSessionsCommand extends BaseLockableCommand
{
    protected static $defaultName = 'app:cleanup-sessions';

    public function __construct(
        DriverFactory $driverFactory,
        protected EntityManagerInterface $entityManager
    ) {
        parent::__construct($driverFactory, $entityManager);
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Cleanup sessions')
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

        $timestamp = (new DateTimeImmutable())->getTimestamp();

        $queryBuilder = $this->entityManager->getConnection()->createQueryBuilder();
        $queryBuilder
            ->delete('session')
            ->where('slifetime < :timestamp')
            ->setParameter('timestamp', $timestamp)
            ->execute()
        ;

        $this->release();

        return Command::SUCCESS;
    }
}
