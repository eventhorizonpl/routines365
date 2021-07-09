<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Event\UserLastActivityUpdate;
use App\Manager\UserManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private UserManager $userManager,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UserLastActivityUpdate::NAME => 'onLastActivityUpdate',
        ];
    }

    public function onLastActivityUpdate(UserLastActivityUpdate $userLastActivityUpdate): void
    {
        $this->userManager->updateLastActivityAt($userLastActivityUpdate->getUser());
    }
}
