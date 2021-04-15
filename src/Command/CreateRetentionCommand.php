<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\RetentionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{InputInterface, InputOption};
use Symfony\Component\Console\Output\OutputInterface;

class CreateRetentionCommand extends BaseLockableCommand
{
    protected static $defaultName = 'app:create-retention';

    public function __construct(
        EntityManagerInterface $entityManager,
        private RetentionService $retentionService
    ) {
        parent::__construct($entityManager);
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Create retention')
            ->addOption(
                'today',
                null,
                InputOption::VALUE_OPTIONAL,
                'Today date for report'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (false === $this->lock()) {
            $output->writeln('The command is already running in another process.');

            return Command::FAILURE;
        }

        $today = $input->getOption('today');
        $this->retentionService->run($today);

        $this->release();

        return Command::SUCCESS;
    }
}
