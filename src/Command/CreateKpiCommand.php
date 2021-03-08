<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\KpiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateKpiCommand extends BaseLockableCommand
{
    protected static $defaultName = 'app:create-kpi';

    public function __construct(
        EntityManagerInterface $entityManager,
        private KpiService $kpiService
    ) {
        parent::__construct($entityManager);
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Create KPI report')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (false === $this->lock()) {
            $output->writeln('The command is already running in another process.');

            return Command::FAILURE;
        }

        $this->kpiService->create();

        $this->release();

        return Command::SUCCESS;
    }
}
