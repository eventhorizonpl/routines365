<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\PostRemindMessagesService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PostRemindMessagesCommand extends Command
{
    use LockableTrait;

    protected static $defaultName = 'app:post-remind-messages';
    private PostRemindMessagesService $postRemindMessagesService;

    public function __construct(PostRemindMessagesService $postRemindMessagesService)
    {
        $this->postRemindMessagesService = $postRemindMessagesService;

        parent::__construct();
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
