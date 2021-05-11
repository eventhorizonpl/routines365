<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\UserKytService;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\MaintenanceBundle\Drivers\DriverFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PostUserKytMessagesCommand extends BaseLockableCommand
{
    protected static $defaultName = 'app:post-user-kyt-messages';

    public function __construct(
        DriverFactory $driverFactory,
        EntityManagerInterface $entityManager,
        private UserKytService $userKytService
    ) {
        parent::__construct($driverFactory, $entityManager);
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Post UserKyt messages')
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

        $this->userKytService->nurture();

        $this->release();

        return Command::SUCCESS;
    }
}
