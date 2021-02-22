<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RewardUserActivityCommand extends BaseLockableCommand
{
    protected static $defaultName = 'app:reward-user-activity';
    private UserService $userService;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserService $userService
    ) {
        $this->userService = $userService;

        parent::__construct($entityManager);
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Reward User activity')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (false === $this->lock()) {
            $output->writeln('The command is already running in another process.');

            return Command::FAILURE;
        }

        $this->userService->rewardUserActivity();

        $this->release();

        return Command::SUCCESS;
    }
}
