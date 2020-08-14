<?php

namespace App\Command;

use App\Service\KpiService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateKpiCommand extends Command
{
    use LockableTrait;

    protected static $defaultName = 'app:create-kpi';
    private KpiService $kpiService;

    public function __construct(KpiService $kpiService)
    {
        $this->kpiService = $kpiService;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Create KPI report')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->lock()) {
            $output->writeln('The command is already running in another process.');

            return Command::SUCCESS;
        }

        $this->kpiService->create();

        $this->release();

        return 0;
    }
}
