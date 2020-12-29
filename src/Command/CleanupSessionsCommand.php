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
