<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\PostRemindMessagesService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PostRemindMessagesCommand extends BaseLockableCommand
{
    protected static $defaultName = 'app:post-remind-messages';

    public function __construct(
        EntityManagerInterface $entityManager,
        private PostRemindMessagesService $postRemindMessagesService
    ) {
        parent::__construct($entityManager);
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Post remind messages')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (false === $this->lock()) {
            $output->writeln('The command is already running in another process.');

            return Command::FAILURE;
        }

        $this->postRemindMessagesService->nurture();

        $this->release();

        return Command::SUCCESS;
    }
}
