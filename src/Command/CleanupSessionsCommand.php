<?php

declare(strict_types=1);

namespace App\Command;

use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CleanupSessionsCommand extends BaseLockableCommand
{
    protected static $defaultName = 'app:cleanup-sessions';
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;

        parent::__construct($entityManager);
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

        $timestamp = (new DateTimeImmutable())->getTimestamp();

        $output->writeln('Deleting sessions older than '.$timestamp);

        $queryBuilder = $this->entityManager->getConnection()->createQueryBuilder();
        $number = $queryBuilder
            ->delete('session')
            ->where('slifetime < :timestamp')
            ->setParameter('timestamp', $timestamp)
            ->execute()
        ;

        $output->writeln('Number of deleted sessions = '.$number);

        $this->release();

        return Command::SUCCESS;
    }
}
